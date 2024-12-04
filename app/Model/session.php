<?php
include_once(__DIR__ . "../../configdb.php");
class Session
{
    public function create_session(int $id)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT * FROM utilisateurs WHERE id = :id";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $token = bin2hex(random_bytes(16));
                $expiration = date('Y-m-d H:i:s', time() + (60 * 60 * 24));
                $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
                $device_info = $_SERVER['HTTP_USER_AGENT'];
                $query = "INSERT INTO user_sessions (user_id, session_token, expires_at, device_info, ip_address) 
                      VALUES (:id, :token, :expiration, :device_info, :ip_address)";
                $stmt = $sql->prepare($query);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $stmt->bindParam(':expiration', $expiration, PDO::PARAM_STR);
                $stmt->bindParam(':device_info', $device_info, PDO::PARAM_STR);
                $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
                $stmt->execute();
                return $token;
            } else {
                return "No user found with the provided ID.";
            }
        } catch (PDOException $e) {
            error_log("Error creating session: " . $e->getMessage());
            return "Error creating session: " . $e->getMessage();  // Return the error message
        } catch (Exception $e) {
            error_log("Unexpected error: " . $e->getMessage());
            return "An unexpected error occurred while creating the session.";  // Catch other exceptions
        }
    }
    public function validateSession(string $token)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT * FROM user_sessions WHERE session_token = :token";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                if ($row['expires_at'] <= date('Y-m-d H:i:s')) {
                    return false;
                }
                $current_ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
                if ($row['ip_address'] !== $current_ip) {
                    error_log("Session validation failed: IP address mismatch.");
                    return false;
                }

                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error validating session: " . $e->getMessage());
            return false;
        }
    }
    public function destroySession(string $token)
    {
        try {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $sql = config::getConnexion();
            $query = "DELETE FROM user_sessions WHERE session_token = :token";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            session_unset();
            session_destroy();
            return true;
        } catch (PDOException $e) {
            error_log("Error destroying session: " . $e->getMessage());
            return false;
        }
    }

    public function cleanUpExpiredSessions()
    {
        try {
            $sql = config::getConnexion();
            $query = "DELETE FROM user_sessions WHERE expires_at <= NOW()";
            $stmt = $sql->prepare($query);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error cleaning up expired sessions: " . $e->getMessage());
            return false;
        }
    }
}
