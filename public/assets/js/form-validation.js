/**
 * Form Validation JavaScript
 * Real-time validation for survey forms
 */

(function() {
    'use strict';

    // Validation rules configuration
    const ValidationRules = {
        required: {
            validate: (value) => value !== null && value !== undefined && String(value).trim() !== '',
            message: 'Field ini wajib diisi'
        },
        email: {
            validate: (value) => !value || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Format email tidak valid'
        },
        nik: {
            validate: (value) => !value || /^\d{16}$/.test(value),
            message: 'NIK harus 16 digit angka'
        },
        phone: {
            validate: (value) => !value || /^(\+62|62|0)[\d\s-]{8,15}$/.test(value.replace(/\s/g, '')),
            message: 'Format nomor HP tidak valid'
        },
        number: {
            validate: (value) => !value || !isNaN(parseFloat(value)),
            message: 'Harus berupa angka'
        },
        minValue: {
            validate: (value, min) => !value || parseFloat(value) >= min,
            message: (min) => `Nilai minimal adalah ${min}`
        },
        maxValue: {
            validate: (value, max) => !value || parseFloat(value) <= max,
            message: (max) => `Nilai maksimal adalah ${max}`
        },
        minLength: {
            validate: (value, min) => !value || value.length >= min,
            message: (min) => `Minimal ${min} karakter`
        }
    };

    // CSS class names
    const CSS_CLASSES = {
        valid: 'is-valid',
        invalid: 'is-invalid',
        feedback: 'validation-feedback',
        feedbackValid: 'valid-feedback',
        feedbackInvalid: 'invalid-feedback'
    };

    /**
     * FormValidator class
     */
    class FormValidator {
        constructor(form) {
            this.form = form;
            this.fields = [];
            this.init();
        }

        init() {
            // Find all input fields with validation rules
            const inputs = this.form.querySelectorAll('[data-validate]');
            
            inputs.forEach(input => {
                this.fields.push({
                    element: input,
                    rules: this.parseRules(input.dataset.validate)
                });

                // Add event listeners
                input.addEventListener('blur', () => this.validateField(input));
                input.addEventListener('input', () => this.validateFieldDebounced(input));
            });

            // Form submit validation
            this.form.addEventListener('submit', (e) => {
                if (!this.validateAll()) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Focus first invalid field
                    const firstInvalid = this.form.querySelector('.' + CSS_CLASSES.invalid);
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }

        parseRules(rulesString) {
            const rules = [];
            const ruleParts = rulesString.split('|');
            
            ruleParts.forEach(part => {
                const [ruleName, param] = part.split(':');
                rules.push({ name: ruleName, param: param });
            });

            return rules;
        }

        validateField(input) {
            const fieldConfig = this.fields.find(f => f.element === input);
            if (!fieldConfig) return true;

            const value = input.value;
            const errors = [];

            fieldConfig.rules.forEach(rule => {
                const validator = ValidationRules[rule.name];
                if (validator) {
                    const isValid = validator.validate(value, rule.param);
                    if (!isValid) {
                        const message = typeof validator.message === 'function' 
                            ? validator.message(rule.param) 
                            : validator.message;
                        errors.push(message);
                    }
                }
            });

            this.showValidation(input, errors);
            return errors.length === 0;
        }

        validateFieldDebounced(input) {
            clearTimeout(input._validateTimeout);
            input._validateTimeout = setTimeout(() => {
                this.validateField(input);
            }, 300);
        }

        validateAll() {
            let isValid = true;
            
            this.fields.forEach(field => {
                if (!this.validateField(field.element)) {
                    isValid = false;
                }
            });

            return isValid;
        }

        showValidation(input, errors) {
            // Remove existing feedback
            const existingFeedback = input.parentElement.querySelector('.' + CSS_CLASSES.feedback);
            if (existingFeedback) {
                existingFeedback.remove();
            }

            // Remove validation classes
            input.classList.remove(CSS_CLASSES.valid, CSS_CLASSES.invalid);

            if (input.value.trim() === '') {
                // Empty field - no visual feedback unless required
                const fieldConfig = this.fields.find(f => f.element === input);
                if (fieldConfig && fieldConfig.rules.some(r => r.name === 'required')) {
                    input.classList.add(CSS_CLASSES.invalid);
                    this.addFeedback(input, errors[0] || 'Field ini wajib diisi', false);
                }
            } else if (errors.length > 0) {
                // Has errors
                input.classList.add(CSS_CLASSES.invalid);
                this.addFeedback(input, errors[0], false);
            } else {
                // Valid
                input.classList.add(CSS_CLASSES.valid);
                this.addFeedback(input, '✓ Valid', true);
            }
        }

        addFeedback(input, message, isValid) {
            const feedback = document.createElement('div');
            feedback.className = `${CSS_CLASSES.feedback} ${isValid ? CSS_CLASSES.feedbackValid : CSS_CLASSES.feedbackInvalid}`;
            feedback.textContent = message;
            
            // Insert after input or input group
            const parent = input.closest('.input-group') || input;
            parent.parentElement.insertBefore(feedback, parent.nextSibling);
        }
    }

    // Auto-initialize on forms with data-realtime-validate
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[data-realtime-validate]');
        forms.forEach(form => {
            new FormValidator(form);
        });

        // Also initialize on forms inside accordion/tab content that may load later
        document.querySelectorAll('[data-validate]').forEach(input => {
            const form = input.closest('form');
            if (form && !form._validator) {
                form._validator = new FormValidator(form);
            }
        });
    });

    // Expose for manual initialization
    window.FormValidator = FormValidator;

})();
