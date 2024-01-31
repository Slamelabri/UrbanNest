const steppers = document.querySelectorAll('.stepper-container');
steppers.forEach((stepperContainer) => {
    const stepper = stepperContainer.querySelector('.stepper');
    const stepperNav = document.querySelector('.stepper-nav[data-stepper-dest="'+stepperContainer.id+'"]');
    const stepperNavLinks = stepperNav.querySelectorAll("button[data-stepper-goto]");
    const tabs = stepper.querySelectorAll('[data-stepper-index]');
    let stepperIndex = 0;

    function validateFields(index) {
        const fields = tabs[index].querySelectorAll('input[required],select[required],textarea[required]');
        let valid = true;

        fields.forEach(field => {
            if (!field.checkValidity()) {
                field.classList.add('form-error');
                valid = false;
            } else {
                field.classList.remove('form-error');
            }
        });

        return valid;
    }

    function stepperNavGoto(dest) {
        stepperNav.querySelectorAll('.active').forEach((stepActive) => {
            stepActive.classList.remove('active');
        });

        const actual = stepperNav.querySelector(`[data-stepper-goto="${dest}"]`);
        actual.classList.add('active');
        actual.classList.remove('past');

        for (let i = 0; i < parseInt(dest); i++) {
            stepperNavLinks[i].classList.add('past');
        }

        for (let i = parseInt(dest) + 1; i < stepperNavLinks.length; i++) {
            stepperNavLinks[i].classList.remove('past');
        }
    }

    function stepperGoTo(goto) {
        if(!validateFields(stepperIndex) && goto!=='before'){
            return;
        }
        stepper.querySelectorAll('.visible').forEach((tab) => {
            tab.classList.remove('visible');
        });

        if (goto === 'before' && stepperIndex > 0) {
            stepperIndex--;
        } else if (goto === 'next' && stepperIndex < tabs.length - 1) {
            stepperIndex++;
        } else {
            stepperIndex = parseInt(goto);
        }

        if (stepperIndex <= 0) {
            stepperContainer.classList.add('step-first');
            stepperContainer.classList.remove('step-end');
            stepperIndex = 0;
        }

        if (stepperIndex > 0 && stepperIndex < tabs.length - 1) {
            stepperContainer.classList.remove('step-first');
            stepperContainer.classList.remove('step-end');
        }

        if (stepperIndex >= tabs.length - 1) {
            stepperContainer.classList.remove('step-first');
            stepperContainer.classList.add('step-end');
            stepperIndex = tabs.length - 1;
        }

        stepper.querySelector(`[data-stepper-index="${stepperIndex}"]`).classList.add('visible');
        stepperNavGoto(stepperIndex);
    }

    stepperContainer.querySelector('[data-stepper-action="next"]').addEventListener('click', function(e) {
        e.preventDefault();
        stepperGoTo('next');
    });

    stepperContainer.querySelector('[data-stepper-action="before"]').addEventListener('click', function(e) {
        e.preventDefault();
        stepperGoTo('before');
    });

    stepperNavLinks.forEach((goto) => {
        goto.addEventListener('click', function(e) {
            e.preventDefault();
            stepperGoTo(this.dataset.stepperGoto);
        });
    });
});