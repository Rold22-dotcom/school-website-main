<?php

session_start();
// this is to know who is the user a guardian , admin or a child
if (!isset($_SESSION['loginuser'])) {

    header("Location: index.php");
    exit();
}
$logintype = $_SESSION['loginuser'];
$logintypejson = json_encode($logintype);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MADALING LEVEL</title>
    <style>
        body {
            background-image: url(img/background.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }

        button:hover {
            background-color: rgb(204, 153, 0);
        }

        button {
            background-color: rgb(148, 76, 43);
            color: rgb(15, 13, 15);
            height: 50px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;

        }

        .button-back {
            width: 200px;
            height: 50px;

        }

        .labelscore {
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;
            background: transparent;
            border: none;

        }

        .incorrect:hover {
            background-color: red;
        }

        #score {
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;
        }

        h2 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;
        }

        @media only screen and (max-width: 414px) {

            #score {
                width: 100px;
            }

        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="data:,">
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<body loading="lazy">

    <!-- Modal  if player say the right thing-->
    <div class="modal" tabindex="-1" id="complete_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="getanswer">Mahusay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p style="font-size: medium; font-family: Arial, Helvetica, sans-serif;">
                        Mahusay nasagot mo and tanong</p>
                    <img src="img/giphy.gif" alt="Tama ang sagot" width="200px" height="200px">
                </div>
            </div>
        </div>
    </div>

<!-- Modal  if player failed-->
<div class="modal" tabindex="-1" id="failed_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="getanswer">Mali</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p style="font-size: medium; font-family: Arial, Helvetica, sans-serif;">
                        Mali ang iyong sagot</p>
                    <img src="img/sadimage.gif" alt="mali ang sagot" width="200px" height="200px">
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="container mt-5">

            <?php
            // question for easymode
            $scorehave = 0;
            $quizquestion = [
                [
                    "question" => "Ano Ang nag sisimula sa letter A sa pinag pipilian?",
                    "choices" => ["Aso", "gitara", "bata", "cake"],
                    "answer" => 0 // Correct answer index (A)
                ],
                [
                    "question" => "Ano Ang nag sisimula sa letter B sa pinag pipilian?",
                    "choices" => ["A-ba-ka", "Baka", "Kubo", "Mapa"],
                    "answer" => 1
                ],
                [
                    "question" => "Ano Ang nag sisimula sa letter K sa pinag pipilian?",
                    "choices" => ["Eroplano", "Ubas", "Mapa", "Kamatis"],
                    "answer" => 3
                ]
            ];

            $quizjson = json_encode($quizquestion);

            ?>

            <div class="text-center"> <input class="labelscore text-center font-italic" value="Score" readonly></div>
            <div id="score_holder" class="text-center"><input class="text-center rounded" id="score" type="text" readonly value=<?= $scorehave ?>></div>

            <div class="position-absolute top-50 start-50 translate-middle d-grid gap-2">
                <h2 class="text-center" id="question"></h2>
                <button class="rounded" id="button_1" onclick="nextQuestion(0)"></button>
                <button class="rounded" id="button_2" onclick="nextQuestion(1)"></button>
                <button class="rounded" id="button_3" onclick="nextQuestion(2)"></button>
                <button class="rounded" id="button_4" onclick="nextQuestion(3)"></button>
            </div>

            <div class="position-absolute bottom-0 start-0"><button class="button-back rounded" onclick="back()">back</button></div>

            <script>
                //change the php to json
                var quizjs = <?= $quizjson ?>;
                var currentQuestionIndex = 0;
                var scorecount = document.getElementById('score');
                var currentScore = parseInt(scorecount.value);
                const playmusicsuccess = new Audio('music/Sfx - Success (@fowksprod).mp3');
                const playmusicfailed = new Audio('music/error-126627.mp3');

                function updateQuiz() {
                    document.getElementById('question').innerHTML = quizjs[currentQuestionIndex].question;
                    document.getElementById('button_1').innerHTML = "A. " + quizjs[currentQuestionIndex].choices[0];
                    document.getElementById('button_2').innerHTML = "B. " + quizjs[currentQuestionIndex].choices[1];
                    document.getElementById('button_3').innerHTML = "C. " + quizjs[currentQuestionIndex].choices[2];
                    document.getElementById('button_4').innerHTML = "D. " + quizjs[currentQuestionIndex].choices[3];
                }

                function ajaxrecord(){
                    if (usertype != null) {
                        const easymode = "easy";
                        const data = {
                            finalscore: scorecount.value,
                            finaltype: usertype,
                            mode: easymode
                        };

                        $.ajax({
                            url: 'function.php',
                            method: 'POST',
                            data: data,
                            success: function(response) {

                                console.log("Response: " + response); // Confirm value arrives
                                setTimeout(() => {
                                    // Ensure AJAX completes first

                                    window.location = "game.php";

                                }, 2000);
                            }
                        });
                    }
                }

                // Function to move to the next question
                function nextQuestion(choiceIndex) {
                    selectedAnswer = document.getElementById('button_' + (choiceIndex + 1));
                    // Check if the selected answer is correct
                    if (choiceIndex === quizjs[currentQuestionIndex].answer) {
                        // Increase the score if the answer is correct
                        currentScore++;
                        scorecount.value = currentScore;
                        // Move to the next question if available
                        if (currentQuestionIndex < quizjs.length - 1) {
                            currentQuestionIndex++;
                            playmusicsuccess.play();
                            $("#complete_modal").modal('show');

                            updateQuiz();
                        } else {
                            playmusicsuccess.play();
                            $("#complete_modal").modal('show');
                            ajaxrecord();

                        }
                    } else {
                        selectedAnswer.classList.add("incorrect");
                        setTimeout(() => {
                            selectedAnswer.classList.remove("incorrect");
                        }, 800);
                        if (currentQuestionIndex < quizjs.length - 1) {
                            currentQuestionIndex++;
                            playmusicfailed.play();
                            $('#failed_modal').modal('show');
                            updateQuiz();
                        }else {
                            playmusicfailed.play();
                            $('#failed_modal').modal('show');
                            ajaxrecord();

                        }
                    }



                }

                // Initialize the first question when the page loads
                updateQuiz();

                function back() {
                    var checking = <?= $logintypejson ?>;
                    if (checking === "admin") {
                        window.location = "game.php";
                    } else if (checking === "guardian") {
                        window.location = "guardian_menu.php";
                    } else {
                        window.location = "kids_menu.php";
                    }

                }
                $('#complete_modal').on('hidden.bs.modal', function() {
                    document.activeElement.blur(); // Remove focus from the modal
                });
            </script>

        </div>

    </div>


</body>

</html>