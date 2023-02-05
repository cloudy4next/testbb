//Prevent inspect element
//document.addEventListener('contextmenu', event => event.preventDefault());
document.onkeydown = function(e) {
    if (event.keyCode == 123) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'C'.charCodeAt(0)) {
        return false;
    }
}

//Question management
let allQuestions = [];
var examId = $('.exam').val();
const token = $('.token').val();
const quizContainer = document.getElementById('quiz');
const output = [];

var getQuestionData = $.ajax({
    url: "/exam/get-question",
    method: 'get',
    data: { 'examId': examId },
    success: function(result) {
        $.each(result, function(key, val) {

            let answer = [];
            if (val.type == 'multiple_choice') {
                var options = JSON.parse(val.answers);
                $.each(options, function(k, v) {
                    if (k == 'option_1' || k == 'option_2' || k == 'option_3' || k == 'option_4') {
                        answer[k] = v;
                    }
                });
            }

            val.answers = answer;
            allQuestions.push(val);
        });
    }
});

function getAttachment(attachments) {
    var attachedFiles = '';
    var attachments = attachments != null ? attachments.split(', ') : '';
    var fileDirectory = $('.file-directory').val();

    if (attachments != '') {
        attachments.forEach(function(val) {
            attachedFiles += '<li><a href="' + fileDirectory + '/' + val + '" download>' + val + '</a></li>';
        });
    }

    return attachedFiles;
}

function runQuestion(index, item, arr) {
    const answers = [];
    var itemType = item.type;
    var attachments = item.attachments;
    var attachedQsnFiles = getAttachment(item.attachments);

    switch (itemType) {
        case 'multiple_choice':

            var i = 0;
            for (var info in item.answers) {
                answers.push(
                    `<div class="form-check">
                        <input class="form-check-input" type="radio" name="question${index}" value="${info}" id="question${index}${i}" ${(info ==  item.applicant_answer? 'checked' : '')}>
                        <label class="form-check-label" for="question${index}${i}">
                            ${item.answers[info]}
                        </label>
                    </div>`
                );
                i++
            }

            output.push(
                `<div class="slide">
                    <div class="card">
                        <div class="card-body">
                            <label style="width: 90%;"></span><h5>${item.priority}. ${item.question}</h5></label></span><span class="float-end">Mark: ${item.marks}</span>
                            ${(attachedQsnFiles != '' ? "<br><b>Attached file: </b>"+ attachedQsnFiles + "<br>" : '')}
                            <input type="hidden" value="${index}">
                            <div class="answers">
                                <input type="hidden" name="priority${index}" value="${item.priority}">
                                <input type="hidden" name="questionId${index}" value="${item.question_id}">
                                <input type="hidden" name="mark${index}" value="${item.marks}">
                                ${answers.join('')}
                            </div>
                        </div>
                    </div>
                </div>`
            );
            break;

        case 'fill_in_the_blank':
            answers.push(
                `<input type="hidden" name="priority${index}" value="${item.priority}">
                <input type="hidden" name="questionId${index}" value="${item.question_id}">
                <input type="hidden" name="mark${index}" value="${item.marks}">
                <label for="question${index}" class="form-label" style="width: 90%;"><h5>${item.priority}. ${item.question}</h5></label><span class="float-end">Mark: ${item.marks}</span>
                ${(attachedQsnFiles != '' ? "<br><b>Attached file: </b>"+ attachedQsnFiles + "<br>" : '')}
                 <input type="text" class="form-control copy-past-control" name="question${index}" id="question${index}" value="${item.applicant_answer}" placeholder="">
                 <div class="mt-3"><small>Note: Separate the answer with a comma.</small><div>
                `
            );

            output.push(
                `<div class="slide">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" value="${index}">
                            <div class="answers">
                                ${answers.join('')}
                            </div>
                        </div>
                    </div>
                </div>`
            );
            break;

        case 'short_descriptive':
            answers.push(
                `<input type="hidden" name="priority${index}" value="${item.priority}">
                <input type="hidden" name="questionId${index}" value="${item.question_id}">
                <input type="hidden" name="mark${index}" value="${item.marks}">
                <label for="question${index}" class="form-label" style="width: 90%;"><h5>${item.priority}. ${item.question}</h5></label><span class="float-end">Mark: ${item.marks}</span>
                ${(attachedQsnFiles != '' ? "<br><b>Attached file: </b>"+ attachedQsnFiles + "<br>" : '')}
                 <textarea class="form-control copy-past-control" name="question${index}" id="question${index}" rows="8">${item.applicant_answer}</textarea>
                 `
            );

            output.push(
                `<div class="slide">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" value="${index}">
                            <div class="answers"> 
                                ${answers.join('')} 
                            </div>
                        </div>
                    </div>
                </div>`
            );
            break;

        case 'descriptive':
            answers.push(
                `<input type="hidden" name="priority${index}" value="${item.priority}">
                <input type="hidden" name="questionId${index}" value="${item.question_id}">
                <input type="hidden" name="mark${index}" value="${item.marks}">
                <label for="question${index}" class="form-label" style="width: 90%;"><h5>${item.priority}. ${item.question}</h5></label><span class="float-end">Mark: ${item.marks}</span>
                ${(attachedQsnFiles != '' ? "<br><b>Attached file: </b>"+ attachedQsnFiles + "<br>" : '')}
                <textarea class="form-control copy-past-control" name="question${index}" id="question${index}" rows="15">${item.applicant_answer}</textarea>
                `
            );

            output.push(
                `<div class="slide">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" value="${index}">
                            <div class="answers"> 
                                ${answers.join('')} 
                            </div>
                        </div>
                    </div>
                </div>`
            );
            break;
        case 'uploads':
            var uploadedFiles = '';
            item.answer_file.split(', ').forEach(function(uploadedSingleFile) {
                uploadedFiles += `
                    <li class="delete-uploaded-file${index} single-file ${(uploadedSingleFile != '' ? '' : 'd-none')}">${uploadedSingleFile}<i class="cross-icon"></i></li>
                `
            });

            answers.push(
                `<input type="hidden" name="priority${index}" value="${item.priority}">
                <input type="hidden" name="questionId${index}" value="${item.question_id}">
                <input type="hidden" name="mark${index}" value="${item.marks}">
                <label for="question${index}" class="form-label" style="width: 90%;"><h5>${item.priority}. ${item.question}</h5></label><span class="float-end">Mark: ${item.marks}</span>
                ${(attachedQsnFiles != '' ? "<br><b>Attached file: </b>"+ attachedQsnFiles + "<br>" : '')}
                <textarea class="form-control copy-past-control" name="question${index}" id="question${index}" rows="15">${item.applicant_answer}</textarea>
                
                <input type="file" class="question-file mt-3" width="50px" id="question-file${index}" name="question_file${index}" multiple>
                <span class="question-file-value${index}">
                    ${uploadedFiles}
                </span>
           
                <div class="mb-3"><small>Note: File should not be greater than 10MB.</small><div>
                <label for="question-file-link${index}" class="form-label mt-3" style="width: 90%;"><h5>Document link</h5></label>
                <input class="form-control file-link-input question-file-link${index}" type="url" name="question_file_link${index}" id="question-file-link${index}" value="${item.answer_link}"></input>
                <div class="mb-3"><small>Note: If your file is more than 10MB, please upload your file online and share the link in this field. use comma to separate the link.</small><div>
                `
            );

            output.push(
                `<div class="slide">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" value="${index}">
                            <div class="answers"> 
                                ${answers.join('')} 
                            </div>
                        </div>
                    </div>
                </div>`
            );
            break;
    }
}

$.when(getQuestionData).then(function() {
    function showQuestions() {
        jQuery.each(allQuestions, runQuestion);
        //quizContainer.innerHTML = output.join('');
        $('#quiz').html(output);
    }

    showQuestions();

    $.when(showQuestions).then(function() {
        //Hide loader.
        $("#loader").hide();

        //Control cut copy paste.
        $('.copy-past-control').bind('cut copy paste', function(event) {
            event.preventDefault();
        });

        // Sliding
        const previousButton = document.getElementById("previous");
        const nextButton = document.getElementById("next");
        const submitButton = document.getElementById("submit");
        const slides = document.querySelectorAll(".slide");
        let currentSlide = 0;

        function showSlide(n) {
            slides[currentSlide].classList.remove('active-slide');
            slides[n].classList.add('active-slide');
            currentSlide = n;
            if (currentSlide === 0) {
                previousButton.style.display = 'none';
            } else {
                previousButton.style.display = 'inline-block';
            }
            if (currentSlide === slides.length - 1) {
                nextButton.style.display = 'none';
                submitButton.style.display = 'inline-block';
            } else {
                nextButton.style.display = 'inline-block';
                submitButton.style.display = 'none';
            }
        }

        showSlide(currentSlide);

        function showNextSlide() {
            showSlide(currentSlide + 1);
        }

        function showPreviousSlide() {
            showSlide(currentSlide - 1);
        }

        function getTotalQuestion() {
            var totalQuestion = document.getElementById('total_question');
            var text = '';

            var i;
            for (i = 1; i < allQuestions.length + 1; i++) {
                text += `<div class="qbtn question_number">${i}</div>`;
            }
            totalQuestion.innerHTML = text;
        }

        getTotalQuestion();

        $('#submit').on('click', function() {
            if (confirm('Are you sure submit your examination?')) {
                submitExam(1);
            }
        });

        //submitButton.addEventListener('click', submitExam(1));
        previousButton.addEventListener("click", showPreviousSlide);
        nextButton.addEventListener("click", showNextSlide);


        //Show specific question
        var allQuestionNumber = document.getElementById('total_question')
        allQuestionNumber.addEventListener('click', showSpecificQuestion)

        function showSpecificQuestion(e) {
            if (e.target.classList.contains('question_number')) {
                var questionNumber = e.target.textContent - 1;
                showSlide(questionNumber);
            }
            e.preventDefault();
        }

        //Review later
        var review = document.getElementById('review');
        review.addEventListener('click', markForLaterReview);

        var review_done = document.getElementById('review-done');
        review_done.addEventListener('click', unMarkForLaterReview);

        function markForLaterReview() {
            var activeSlide = document.querySelector('.active-slide');
            var selector = `input`
            var questionIndex = (activeSlide.querySelector(selector)).value;
            var additionToIndex = parseInt(questionIndex);
            var allQuestion = document.querySelectorAll('.question_number')

            var specificQuestion = allQuestion[additionToIndex]
            specificQuestion.classList.remove('qbtn');
            specificQuestion.classList.add('review');

            if (slides.length - 1 !== additionToIndex) {
                showNextSlide();
            }
        }

        function unMarkForLaterReview() {
            var activeSlide = document.querySelector('.active-slide');
            var selector = `input`
            var questionIndex = (activeSlide.querySelector(selector)).value;
            var additionToIndex = parseInt(questionIndex);
            var allQuestion = document.querySelectorAll('.question_number');

            var specificQuestion = allQuestion[additionToIndex];
            specificQuestion.classList.add('save-continue');
            specificQuestion.classList.remove('review');
            submitExam(0);

            if (slides.length - 1 !== additionToIndex) {
                showNextSlide();
            }
        }

        //Duration management
        var examDate = $('.exam-date').val();
        var startTime = $('.exam-start-time').val();
        startDateTime = examDate + ' ' + startTime;
        var partsStartTime = startDateTime.split('-');
        startDateTime = partsStartTime[0] + '/' + partsStartTime[1] + '/' + partsStartTime[2];

        var endTime = $('.exam-end-time').val();
        endDateTime = examDate + ' ' + endTime;
        var partsEndTime = endDateTime.split('-');
        endDateTime = partsEndTime[0] + '/' + partsEndTime[1] + '/' + partsEndTime[2];

        var isFirstEntry = $('.is-first-entry').val();

        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var todayDate = date.getFullYear() + '/' +
            (month < 10 ? '0' : '') + month + '/' +
            (day < 10 ? '0' : '') + day;

        var currentTime = new Date().getTime();
        var timeStart = new Date(startDateTime).getTime();
        var timeEnd = new Date(todayDate + ' ' + endTime).getTime();
        var timeLeft = timeEnd - currentTime;
        var warningTime = 5 * 60000

        if (examDate == todayDate) {
            if (currentTime < timeStart || currentTime > timeEnd) {
                alert('Please wait!');
                history.go(-1);
            }
        }

        // Set the date we're counting down to
        var countDownDate = new Date().getTime() + timeLeft;

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("timer").innerHTML = hours + "h " + minutes + " : " +
                seconds + ' left';

            if (distance < warningTime) {
                $('#timer').css({ 'color': 'red' });
            }

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "EXPIRED";
                submitExam(1);
            }
        }, 1000);

        //Activity time management
        var unixTimeStampInSec = Math.round(new Date().getTime() / 1000);
        var lastUpdatedLocalTime = localStorage.getItem("lastUpdatedLocalTime");
        var lastUpdatedLocalTimeInSec = Math.round(new Date(lastUpdatedLocalTime).getTime() / 1000);

        var timeDiff = unixTimeStampInSec - lastUpdatedLocalTimeInSec;
        var inActivityTime = Math.round(timeDiff);
        var allowTime = 36000;
        var afterStartExam = (timeStart + 300000) / 1000;

        if (isFirstEntry != 1) {
            if (!lastUpdatedLocalTime || lastUpdatedLocalTime == '') {
                $('body').html('');
                alert('You are too late to join the examination!');
                window.close();
                return false;
            }

            if (inActivityTime > allowTime) {
                $('body').html('');
                alert('You have exceeded the examination rejoinning time limit!');
                window.close();
                return false;
            }

            localStorageTimeManagement();

        } else {
            localStorageTimeManagement();
        }

        function localStorageTimeManagement() {
            setInterval(function() {
                var currentTimeInSec = Math.round(new Date().getTime() / 1000);
                var currentDateTimeInMs = new Date(currentTimeInSec * 1000);
                localStorage.setItem("lastUpdatedLocalTime", currentDateTimeInMs);
            }, 10000);
        }
    });

    $.when(showQuestions).then(function() {
        allQuestions.forEach(function(currentQuestion, questionNumber) {
            $('#question-file' + questionNumber).on('change', function() {
                var fileSize = 0;

                for (var i = 0; i < $(this).get(0).files.length; ++i) {
                    fileSize += $(this).get(0).files[i].size;
                }

                if (fileSize > 10000000) {
                    alert('File size should not be greater than 10MB');
                    return false;
                }

                // if ( fileType != 'text/csv' && fileType != 'application/pdf' && fileType != 'application/msword' &&
                // fileType != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                // && fileType != "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                // && fileType != "image/png"
                // && fileType != "image/jpeg"
                // && fileType != "text/plain"
                // ) {
                //     alert('This file type not support in this system');
                //     return false;
                // }

                var uploadedFile = [];
                var x = 0;

                $('.question-file-value' + questionNumber + ' .single-file').each(function() {
                    var uploadedFileName = $(this).text();
                    uploadedFile[x] = uploadedFileName;
                    x++
                });

                var fileData = new FormData;

                if (uploadedFile != '') {
                    fileData.append('uploaded_file', uploadedFile);
                } else {
                    fileData.append('uploaded_file', '');
                }

                for (var i = 0; i < $(this).get(0).files.length; ++i) {
                    fileData.append('answer_file[]', $(this).get(0).files[i]);
                }

                fileData.append('_token', token);

                $.ajax({
                    url: "/exam/post-answer-file",
                    method: 'post',
                    data: fileData,
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        if (result != 0) {
                            var fileHtml = '';

                            result.forEach(function(fileItem) {
                                fileHtml += `<li class="delete-uploaded-file${questionNumber} single-file">${fileItem}<i class="cross-icon"></i></li>`;
                            });

                            $(this).val('');
                            $('.question-file-value' + questionNumber).html(fileHtml);
                            submitExam(0);
                        } else {
                            alert('There was a problem of your activity!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error', error);
                    }
                });

            });

            $(document).on('click', '.delete-uploaded-file' + questionNumber + " .cross-icon", function() {
                if (confirm('Are you sure ?')) {
                    var deletedFile = $(this).closest('.delete-uploaded-file' + questionNumber).text();
                    var fileDiv = $(this).closest('.delete-uploaded-file' + questionNumber);
                    $.ajax({
                        url: "/exam/delete-answer-file",
                        method: 'get',
                        data: { '_token': token, 'deletedFile': deletedFile },
                        success: function(result) {
                            if (result != 0) {
                                fileDiv.remove();
                                submitExam(0);
                            } else {
                                alert('There was a problem of your activity!');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('error', error);
                        }
                    });
                }
            });
        });
        submitExam(0);
    });
});

function submitExam(finalSubmit) {
    // gather answer containers from our quiz
    const answerContainers = quizContainer.querySelectorAll('.answers');

    const submitData = []

    allQuestions.forEach((currentQuestion, questionNumber) => {

        if (currentQuestion.type === "multiple_choice") {
            // find selected answer
            const questionData = {};
            const answerContainer = answerContainers[questionNumber];
            const selector = `input[name=question${questionNumber}]:checked`;
            const userAnswer = (answerContainer.querySelector(selector) || {}).value;

            const prioritySelector = `input[name=priority${questionNumber}]`;
            const priorityValue = (answerContainer.querySelector(prioritySelector) || {}).value;

            const questionIdSelector = `input[name=questionId${questionNumber}]`;
            const questionIdValue = (answerContainer.querySelector(questionIdSelector) || {}).value;

            const markSelector = `input[name=mark${questionNumber}]`;
            const markValue = (answerContainer.querySelector(markSelector) || {}).value;

            questionData.priority = priorityValue;
            questionData.question_id = questionIdValue;
            questionData.user_answer = (userAnswer == undefined ? '' : userAnswer);
            questionData.mark = markValue;
            submitData.push(questionData);

        } else if (currentQuestion.type === "fill_in_the_blank") {
            const questionData = {};
            const answerContainer = answerContainers[questionNumber];
            const selector = `input[name=question${questionNumber}]`;
            const userAnswer = (answerContainer.querySelector(selector) || {}).value;

            const prioritySelector = `input[name=priority${questionNumber}]`;
            const priorityValue = (answerContainer.querySelector(prioritySelector) || {}).value;

            const questionIdSelector = `input[name=questionId${questionNumber}]`;
            const questionIdValue = (answerContainer.querySelector(questionIdSelector) || {}).value;

            const markSelector = `input[name=mark${questionNumber}]`;
            const markValue = (answerContainer.querySelector(markSelector) || {}).value;

            questionData.priority = priorityValue;
            questionData.question_id = questionIdValue;
            questionData.user_answer = userAnswer;
            questionData.mark = markValue;
            submitData.push(questionData);

        } else if (currentQuestion.type === "short_descriptive" || currentQuestion.type === "descriptive") {

            const questionData = {};
            const answerContainer = answerContainers[questionNumber];
            const selector = `textarea[name=question${questionNumber}]`;
            const userAnswer = (answerContainer.querySelector(selector) || {}).value;

            const prioritySelector = `input[name=priority${questionNumber}]`;
            const priorityValue = (answerContainer.querySelector(prioritySelector) || {}).value;

            const questionIdSelector = `input[name=questionId${questionNumber}]`;
            const questionIdValue = (answerContainer.querySelector(questionIdSelector) || {}).value;

            const markSelector = `input[name=mark${questionNumber}]`;
            const markValue = (answerContainer.querySelector(markSelector) || {}).value;

            questionData.priority = priorityValue;
            questionData.question_id = questionIdValue;
            questionData.user_answer = userAnswer;
            questionData.mark = markValue;
            submitData.push(questionData);

        } else if (currentQuestion.type === "uploads") {

            const questionData = {};
            const answerContainer = answerContainers[questionNumber];
            const selector = `textarea[name=question${questionNumber}]`;
            const userAnswer = (answerContainer.querySelector(selector) || {}).value;

            const prioritySelector = `input[name=priority${questionNumber}]`;
            const priorityValue = (answerContainer.querySelector(prioritySelector) || {}).value;

            const questionIdSelector = `input[name=questionId${questionNumber}]`;
            const questionIdValue = (answerContainer.querySelector(questionIdSelector) || {}).value;

            const markSelector = `input[name=mark${questionNumber}]`;
            const markValue = (answerContainer.querySelector(markSelector) || {}).value;

            var answerFile = '';
            $('.question-file-value' + questionNumber + ' .single-file').each(function() {
                var fileName = $(this).text();

                if (answerFile == '') {
                    answerFile += fileName;
                } else {
                    answerFile += ', ' + fileName;
                }
            });

            var answerFileLink = $('.question-file-link' + questionNumber).val();

            (answerFile != '' || answerFile != undefined ? questionData.answer_file = answerFile : questionData.answer_file = '')
            questionData.priority = priorityValue;
            questionData.answer_file_link = answerFileLink;
            questionData.question_id = questionIdValue;
            questionData.user_answer = userAnswer;
            questionData.mark = markValue;
            submitData.push(questionData);
        }
    })

    //submit all data
    const examData = {};
    var examId = $('.exam').val();

    examData.exam_id = examId;
    examData.answer_data = submitData;
    examData.submit_status = finalSubmit;

    $.ajax({
        url: "/exam/post-answer",
        method: 'post',
        data: { '_token': token, 'examData': examData },
        success: function(result) {
            if (result != 0) {
                if (finalSubmit == 1) {
                    localStorage.removeItem('lastUpdatedLocalTime');
                    window.location.replace("/exam/success");
                }
            } else {
                alert('There was a problem of your activity!');
                window.close();
            }
        },
        error: function(xhr, status, error) {
            console.log('error', error);
        }
    });
}

//Save exam data after every five minutes
$(document).ready(function(e) {
    setInterval(function() {
        submitExam(0);
    }, 300000);
});
