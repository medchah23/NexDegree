<div class="semester-selection">
  <form action="affichematiere.php" method="GET">
    <label for="semester">Select Semester: </label>
    <select name="semester" id="semester" onchange="this.form.submit()">
      <option value="1" <?= isset($_GET['semester']) && $_GET['semester'] == 1 ? 'selected' : '' ?>>Semester 1</option>
      <option value="2" <?= isset($_GET['semester']) && $_GET['semester'] == 2 ? 'selected' : '' ?>>Semester 2</option>
      <option value="3" <?= isset($_GET['semester']) && $_GET['semester'] == 3 ? 'selected' : '' ?>>Semester 3</option>
    </select>
  </form>
</div>