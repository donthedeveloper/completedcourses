<?php

require_once('resources/config.php');
require_once('classes/database.php');
require_once('classes/courses.php');

// Connect to database
$db = new Database($dbConfig);

// Query database for course information
$results = $db->getSelect('SELECT 
		courses.id AS course_id, 
		courses.name AS course_name, 
		courses.description AS course_description, 
		courses.tag AS course_tag, 
		courses.length AS course_length, 
		courses.completed AS course_completed, 
		instructors.name AS instructor_name, 
		instructors.twitter AS instructor_twitter, 
		instructors.img_url AS instructor_img, 
		stages.name AS stage_name, 
		stages.description AS stage_description 
	FROM stages 
	INNER JOIN courses ON stages.course_id = courses.id 
	INNER JOIN instructors ON courses.instructor_id = instructors.id
	ORDER BY course_completed DESC;');
$rows = $results->fetchAll(PDO::FETCH_ASSOC);

$stages = array();
$course = '';
$courses = array();
$tags = array();

// Loop through query results
foreach($rows as $row) {
	
	// Form tags array
	if (!in_array($row['course_tag'], $tags)) {
		array_push($tags, $row['course_tag']);
	}

	// If object exists in array with key of id
	if (array_key_exists($row['course_id'], $courses)) {
		// Update associative array of stages
		$stages[$row['stage_name']] = $row['stage_description'];
		// Update current course object with current updated stages array
		${'id_' . $row['course_id']}->updatestages($stages);
	} else {		
		// First, clear stages array since this is a new course
		unset($stages);
		$stages = array();
		
		// Next, create associative array for stages
		$stages = array($row['stage_name'] => $row['stage_description']);
		
		// Create Object
		${'id_' . $row['course_id']} = new Course(
			$row['course_name'], 
			$row['course_description'], 
			$row['course_tag'], 
			$row['course_length'], 
			$row['course_completed'], 
			$row['instructor_name'], 
			$row['instructor_twitter'],
			$row['instructor_img'], 
			$stages
		);
		// Create associative courses array with each key as the current course id
		$courses[$row['course_id']] = ${'id_' . $row['course_id']};
	}
}

?>

<!DOCTYPE>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	
	<body>
		<header>
			<h1>Completed Courses</h1>
			<h2>By Don Hansen</h2>
		</header>
		<ul class="nav group">
			<li>
				<button class="html" type="button">
					HTML
				</button>
			</li>
			<li>
				<button class="css" type="button">
					CSS
				</button>
			</li>
			<li>
				<button class="javascript" type="button">
					JavaScript
				</button>
			</li>
			<li>
				<button class="php" type="button">
					PHP
				</button>
			</li>
			<li>
				<button class="databases" type="button">
					Databases
				</button>
			</li>
			<li>
				<button class="design" type="button">
					Design
				</button>
			</li>
			<li>
				<button class="business" type="button">
					Business
				</button>
			</li>
			<li>
				<button class="development_tools" type="button">
					Development Tools
				</button>
			</li>
		</ul>	
		
<?php 
	foreach($courses as $key => $course) {
		$id = ${'id_' . $key};
?>
		<div class="<?php echo 'course ' . strtolower($id->course_tag); ?>">
			<div class="course_head">
				<h2 class="course_name"><?php echo $id->course_name; ?></h2>
				<div class="clipnotes group">
					<img class="instructor_img" alt="<?php echo $id->instructor_name; ?>" src="<?php echo $id->instructor_img ?>" />
					<div class="course_information">
						<p>Taught by <span class="highlight"><?php echo $id->instructor_name; ?></span></p>
						<p><?php echo $id->course_length; ?>-minute <?php echo str_ireplace("_", " ", $id->course_tag); ?> course</p>
						<p>Completed on <span class="highlight"><?php echo date('F, d, Y', strtotime($id->course_completed)); ?></span></li>
					</div>
				</div>
			</div>
			<div class="course_body">
				<p class="course_description"><?php echo $id->course_description; ?></p>
				<div class="stages">
<?php
		foreach($id->stages as $stage_name => $stage_description) {
?>
					<h3><?php echo $stage_name; ?></h3>
					<p><?php echo $stage_description; ?></p>
<?php
		}
?>
				</div>
			</div>
		</div>
<?php
	} 
?>
		<footer class="group">
			<p>&copy; <?php echo date("Y") ?> Don Hansen. All Rights Reserved.</p>
			<p>
				<a href="http://donhansen.me">Donhansen.me</a>
			</p>
		</footer>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>


