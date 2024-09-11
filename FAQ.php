<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="faq.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="faq.js"></script>
    <title>FAQ</title>
    
</head>
<body>
    <!-- Add To Sidebar -->
    <?php include 'sidebar.php'; ?>

    <header>
        <h1>Frequently Asked Questions</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="questions">
        <!-- question1 -->
        <img class="Answers" alt="Image 1" onclick="showAnswer(answer1)">
        <div id="answer1" class="resumeContent">
            
        </div>

        <!-- question1 -->
        <img class="Answers" alt="Image 1" onclick="showAnswer(answer1)">
        <div id="answer1" class="resumeContent">
            
        </div>
        <!-- question1 -->
        <img class="Answers" alt="Image 1" onclick="showAnswer(answer1)">
        <div id="answer1" class="resumeContent">
            
        </div>
        <!-- Add more images as needed -->
    </div>
    
</body>
</html>
