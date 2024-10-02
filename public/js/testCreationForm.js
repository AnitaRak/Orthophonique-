document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('click', handleClickEvents);

    function handleClickEvents(e) {
        // MCQ checked on question template
        if (e.target && e.target.classList.contains('target-qt-mcq')) {
            handleMcqChangeOnRegistered(e);
        }
        // REMOVE TEMPLATE QUESTION 
        // Check if the clicked element is a 'removeTQuestion' button
        if (e.target && e.target.classList.contains('removeTQuestion')) {
            handleRemoveQuestion(e);
        }
        if (e.target && e.target.classList.contains('removeTValue')) {
            handleRemoveTValue(e);
        }

    }

    function handleRemoveQuestion(e) {
        e.preventDefault();
        const questionIndex = e.target.dataset.questionIndex;
        const itemToRemove = document.getElementById(`test_form_templateQuestions_${questionIndex}`);
        const parentBox = itemToRemove.closest('.template-question-box');

        if (confirm("Êtes-vous sûre de vouloir supprimer cette question ?")) {
            // Remove the entire form item and its parent with class 'template-question-box'
            itemToRemove.remove();
            if (parentBox) {
                parentBox.remove();
            }
            e.target.remove();
        }
    }
    // ADD NEW FORM FOR TEMPLATE VALUE 
    document.querySelectorAll('.add_template_value_link').forEach(btn => {
        btn.addEventListener("click", addTemplateValueForm);
    });
    // ADD NEW FORM FOR TEMPLATE QUESTION 
    document.querySelectorAll('.add_template_question_link').forEach(btn => {
        btn.addEventListener("click", addTemplateQuestionForm);
    });

    function addTemplateQuestionForm(e) {
        e.preventDefault();
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
        const item = document.createElement('div');
        item.innerHTML += `
            ${collectionHolder.dataset.prototype.replace(
            /__name__/g,
            collectionHolder.dataset.index
        )}
        `;
        // We want that if the mcq input is checked, to propose to create template values
        const mcqInput = item.querySelector('#test_form_templateQuestions_' + collectionHolder.dataset.index + '_is_mcq');
        if (mcqInput) {

            mcqInput.addEventListener('change', function (event) {
                handleMcqChange(event, collectionHolder.dataset.index - 1, item);
            });
        }
        item.classList.add('template-question-box');

        const cancelButton = createCancelButton(collectionHolder.dataset.index, "question");
        const addTemplateValueBtn = addTemplateValueButton(collectionHolder.dataset.index, item, "removeTQuestion");
        item.appendChild(addTemplateValueBtn);
        collectionHolder.appendChild(item);
        collectionHolder.appendChild(cancelButton);
        collectionHolder.dataset.index++;
    }

    // FORM VALIDATION
    // Click event listener for the "Enregistrer" button
    document.getElementById('validationForm').addEventListener('click', handleValidationForm);

    function handleValidationForm(e) {
        // Validate the template questions
        const isValid = validateTemplateQuestions();
        console.log("validation")
        // If validation fails, show an alert and do not submit the form
        if (!isValid) {
            e.preventDefault();
            alert("La validation des questions a échoué.");
        } else {
            // If validation passes, programmatically submit the form
            document.querySelector('form').submit();
        }
    }

    function validateTemplateQuestions() {
        // I want a boolean (mcq, text, audio) to be checked for each question
        const templateQuestions = document.querySelectorAll('.template-question-box');
        let isValid = true;
        const allPrefix = "test_form_templateQuestions_";

        templateQuestions.forEach((question) => {
            // Check if the name of the first child begins with "test_form_templateQuestions_"
            let onePrefix;
            // case : new form 
            if (question.children[0].id.startsWith(allPrefix)) {
                onePrefix = question.children[0].id;
                // case template question already registered
            } else {
                // If not, use data-question-index attribute to concatenate with allPrefix
                const index = question.dataset.questionIndex - 1;
                onePrefix = allPrefix + index;
            }
            // Search for our checkboxes in the DOM
            let audio_id = onePrefix + "_requires_audio";
            let text_id = onePrefix + "_requires_text";
            let mcq_id = onePrefix + "_is_mcq";
            let custom_score_id = onePrefix + "_is_custom_score";

            // Use optional chaining to handle the case where checked attribute may not exist
            const requiresAudio = Number(document.getElementById(audio_id)?.checked) || 0;
            const requiresText = Number(document.getElementById(text_id)?.checked) || 0;
            const isMcq = Number(document.getElementById(mcq_id)?.checked) || 0;
            const isCustomScore = Number(document.getElementById(custom_score_id)?.checked) || 0;

            const counter = requiresAudio + requiresText + isMcq + isCustomScore;
            if (counter !== 1) {
                isValid = false;
                // Log or alert the specific error if needed
                alert(`La question ${onePrefix.charAt(onePrefix.length) - 1} est invalide. Pour qu'une question soit valide, elle doit soit être un questionnaire à choix multiple, soit demander la saisie d'un texte ou d'un score, ou l'enregistrement d'un audio.`);
            }

        });
        return isValid;
    }
});