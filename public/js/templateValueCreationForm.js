// UTILS 

function createCancelButton(valueIndex, name, classname) {
    const cancelButton = document.createElement("button");
    cancelButton.className = "btn btn-outline-danger " + classname;
    cancelButton.setAttribute("data-value-index", valueIndex);
    cancelButton.textContent = "Annuler cette " + name;
    return cancelButton;
}

// ADD TEMPLATE QUESTION WITH MCQ
function handleMcqChange(event, index, item) {
    const optionButton = item.querySelector('#addTemplateValueFormBtn_' + index);

    if (event.target.checked) {
        // Display the "Ajouter une nouvelle option de réponse" button
        if (optionButton) {
            optionButton.style = "";
        } else if (!optionButton) {
            btn = addTemplateValueButton(index, item);
            btn.style = "";
        }
    } else {
        // Hide the "Ajouter une nouvelle option de réponse" button
        if (optionButton) {
            optionButton.style.display = 'none';
        }
    }
    return optionButton;
}

function addTemplateValueButton(index, item) {
    // Create the "Ajouter une nouvelle option de réponse" button
    const button = document.createElement('button');
    button.className = "btn btn-outline-primary";
    button.textContent = "Ajouter une nouvelle option de réponse";
    button.id = 'addTemplateValueFormBtn_' + index;

    // Initially hide the button
    button.style.display = 'none';

    // Add your logic to handle the click event of the button
    button.addEventListener('click', function () {
        handleAddTemplateValueClick(index);
    });

    return button;
}

//FIXME. For now when we click on that btn, it submit the form.
function handleAddTemplateValueClick(index) {
    // Your logic when the "Ajouter une nouvelle option de réponse" button is clicked
    console.log("Button clicked for question index:", index);
    // Add your code to handle the button click event as needed
}

// ADD TEMPLATE VALUE
// This button just sumbit the form so that the question template is already set
function handleMcqChangeOnRegistered(event) {
    var item = event.target.parentNode.parentNode;
    var index = event.target.id.charAt(event.target.id.length - 8);
    if (event.target.checked) {
        btn = addTemplateValueButton(index, item);
        item.appendChild(btn);
        btn.style = "";
    } else {
        var btnToRemove = document.getElementById('addTemplateValueFormBtn_' + index);
        if (btnToRemove) {
            item.removeChild(btnToRemove);
        }
    }
}
function addTemplateValueForm(e) {
    e.preventDefault();
    //Select the right Template Question to add TemplateValues to it
    const collectionHolderClass = e.currentTarget.dataset.collectionHolderClass;
    const collectionHolders = document.querySelectorAll('.' + collectionHolderClass);
    var collectionHolder = null;

    // Iterate over each element in the NodeList
    collectionHolders.forEach(aCollectionHolder => {
        // Check if dataset.tqId values match
        if (e.target.dataset.tqId === aCollectionHolder.dataset.tqId) {
            collectionHolder = aCollectionHolder;
            // Exit the loop once the right node is found
            return;
        }
    });

    // Generate the form
    const item = document.createElement('div');
    item.innerHTML += `
        ${collectionHolder.dataset.prototype.replace(
        /__name__/g,
        collectionHolder.dataset.index
    )}
    `;
    item.classList.add('template-value-box');

    const cancelButton = createCancelButton(collectionHolder.dataset.index, "valeur", "removeTValue");
    const addTemplateValueBtn = addTemplateValueButton(collectionHolder.dataset.index, item);
    item.appendChild(addTemplateValueBtn);
    collectionHolder.appendChild(item);
    collectionHolder.appendChild(cancelButton);
    collectionHolder.dataset.index++;
}
function handleRemoveTValue(e) {
    e.preventDefault();
    // Question index is set on the closest parent element with the class template-question-box
    const templateQuestionBox = e.target.closest('.template-question-box');
    const questionIndex = templateQuestionBox.dataset.questionIndex - 1;
    const valueIndex = e.target.dataset.valueIndex;
    const itemToRemove = document.getElementById(`test_form_templateQuestions_${questionIndex}_templateValues_${valueIndex}`);
    const parentBox = itemToRemove.closest('.template-value-box');

    if (confirm("Êtes-vous sûre de vouloir supprimer cette option ?")) {
        // Remove the entire form item and its parent with class 'template-question-box'
        itemToRemove.remove();
        if (parentBox) {
            parentBox.remove();
        }
        e.target.remove();
    }
}