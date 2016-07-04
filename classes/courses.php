<?php

class Course {
	function __construct(
		$course_name, 
		$course_description, 
		$course_tag, 
		$course_length, 
		$course_completed, 
		$instructor_name, 
		$instructor_twitter, 
		$instructor_img, 
		$stages
		)
	{
		$this->course_name = $course_name;
		$this->course_description = $course_description;
		$this->course_tag = $course_tag;
		$this->course_length = $course_length;
		$this->course_completed = $course_completed;
		$this->instructor_name = $instructor_name;
		$this->instructor_twitter = $instructor_twitter;
		$this->instructor_img = $instructor_img;
		$this->stages = $stages;
	}
	
	function updatestages($stages) {
	$this->stages = $stages;
	}
}

?>