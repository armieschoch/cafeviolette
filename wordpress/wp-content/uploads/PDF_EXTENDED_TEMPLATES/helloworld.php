<?php

// Template Name: Hello World
// Version: 0.1
// Description: A basic "Hello World" PDF template showing custom PDF templates in action
// Author: Jake Jackson
// Author URI: https://gravitypdf.com
// Group: Sol System
// License: GPLv2
// Required PDF Version: 4.0
// Tags: space, solar system, getting started


/* Prevent direct access to the template (always good to include this) */

if ( ! class_exists( 'GFForms' ) ) {
  return;
}

 ?>

 <!-- Any PDF CSS styles can be placed in the style tag below -->
<style>
h1 {
  text-align: center;
  text-transform: uppercase;
  color: #a62828;
  border-bottom: 1px solid #999;
}

</style>

<h1>Hello World</h1>
<p>You're from {Where do you live?:3}, {Name (First):1.3}? How cool is that!</p>

[gravityforms action="conditional" merge_tag="{Where do you live?:3}" condition="is" value="Earth"]
	The birth-rate on Earth has dropped almost 25% in the past 50 years due to colonisation of the solar system.
[/gravityforms]

[gravityforms action="conditional" merge_tag="{Where do you live?:3}" condition="is" value="Moon"]
	The lunar colony was first established in 2115 with a population of 200. Now it supports over 900,000 people.
[/gravityforms]

[gravityforms action="conditional" merge_tag="{Where do you live?:3}" condition="is" value="Mars"]
	Mars was the second body to be colonised in the solar system in 2135, 20 years after the moon.
[/gravityforms]

[gravityforms action="conditional" merge_tag="{Where do you live?:3}" condition="is" value="Titan"]
	Titan's colony is only recently established. You're one of only 500 people currently living there!
[/gravityforms]
