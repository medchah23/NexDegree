from deepface import DeepFace
import sys
import json

def recognize_faces(image1_path, image2_path):
    try:
        result = DeepFace.verify(image1_path, image2_path)
        return json.dumps(result)
    except Exception as e:
        return json.dumps({"error": str(e)})

if __name__ == "__main__":
    # Taking the image paths as command line arguments
    image1 = sys.argv[1]
    image2 = sys.argv[2]

    result = recognize_faces(image1, image2)
    print(result)
