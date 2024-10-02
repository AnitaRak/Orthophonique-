document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('click', handleClickEvents);

    function handleClickEvents(e) {
        // MCQ checked on the question template
        if (e.target && e.target.classList.contains('add_option_response')) {
            generateOptionResponseForm(e);
        }
    }
});

function generateOptionResponseForm(e) {
    e.preventDefault();
    const itemID = e.target.dataset.itemId;
    const templateValueID = e.target.dataset.tvalueId;
    const questionID = e.target.dataset.questionId;
    const collectionHolder = document.querySelector('.' + e.target.dataset.collectionHolderClass);

    const item = document.createElement('div');
    item.innerHTML += `
         ${collectionHolder.dataset.prototype.replace(
        /__name__/g,
        collectionHolder.dataset.index
    )}
     `;
    const style = "display : none";
    const questionSelect = item.querySelector('.question-select'); // Update this line based on the actual class
    questionSelect.value = questionID;

    // Set the value of the templateValue select element
    const templateValueSelect = item.querySelector('.template-value-select'); // Update this line based on the actual class
    templateValueSelect.value = templateValueID;
    const mediaInput = item.querySelector('.media-value-select');

    // We hide everything we don't want to user to modify here
    templateValueSelect.style = style;
    questionSelect.style = style;
    mediaInput.style = style;

    item.classList.add('option-response-box');
    const cancelButton = createCancelButton(collectionHolder.dataset.index, "option", "removeBtn");
    const saveOptionResponseBtn = addSaveOptionResponseBtn(collectionHolder.dataset.index, item, "saveOptionResponse");
    item.appendChild(saveOptionResponseBtn);
    collectionHolder.appendChild(item);
    collectionHolder.appendChild(cancelButton);
    collectionHolder.dataset.index++;
}

function createCancelButton(valueIndex, name, classname) {
    const cancelButton = document.createElement("button");
    cancelButton.className = "btn btn-outline-danger " + classname;
    cancelButton.setAttribute("data-value-index", valueIndex);
    cancelButton.textContent = "Annuler cette " + name;
    return cancelButton;
}

function addSaveOptionResponseBtn(index, item, classname) {
    // Create the "Ajouter une nouvelle option de réponse" button
    const button = document.createElement('button');
    button.className = "btn btn-primary " + classname; // Add classname
    button.textContent = "Enregistrer";
    button.id = 'addOptionResponseBtn_' + index;

    // Add your logic to handle the click event of the button
    button.addEventListener('click', function () {
        saveOptionReponse(index);
    });

    // Append the button to the item
    item.appendChild(button);

    return button;
}
// TODO demain optionResponseMedias does not exists
function saveOptionReponse(index) {
    const form = document.getElementById('question-form');
    form.submit();
}


