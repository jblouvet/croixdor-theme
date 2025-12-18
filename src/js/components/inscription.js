export class InscriptionForm {
	constructor() {
		this.modal = document.getElementById('inscription-modal');
		this.form = document.getElementById('inscription-form');
		this.messageContainer = document.getElementById('form-message');
		this.submitButton = this.form ? this.form.querySelector('button[type="submit"]') : null;

		this.init();
	}

	init() {
		if (!this.modal || !this.form) return;

		// Use event delegation for triggers
		document.addEventListener('click', (e) => {
			const trigger = e.target.closest('a[href="#inscription"], button[href="#inscription"], [data-href="#inscription"]');
			if (trigger) {
				e.preventDefault();
				this.openModal();
			}
		});

		// Close when clicking outside content
		this.modal.addEventListener('click', (e) => {
			if (e.target === this.modal) {
				this.closeModal();
			}
		});

		// Handle escape key
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && this.modal.classList.contains('active')) {
				this.closeModal();
			}
		});

		// Form submission
		this.form.addEventListener('submit', (e) => this.handleSubmit(e));
	}

	openModal() {
		this.modal.classList.add('active');
		document.body.style.overflow = 'hidden'; // Prevent background scrolling
	}

	closeModal() {
		this.modal.classList.remove('active');
		document.body.style.overflow = '';
		this.resetForm();
	}

	async handleSubmit(e) {
		e.preventDefault();

		// Clear previous messages
		this.messageContainer.classList.add('hidden');
		this.messageContainer.classList.remove('bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

		// loading
		this.setLoading(true);

		const formData = new FormData(this.form);

		// Add action and nonce for WP AJAX
		formData.append('action', 'submit_inscription');
		if (window.croixdorParams && window.croixdorParams.nonce) {
			formData.append('nonce', window.croixdorParams.nonce);
		}

		try {
			// Check if ajaxUrl is defined
			const ajaxUrl = window.croixdorParams?.ajaxUrl;
			if (!ajaxUrl) {
				throw new Error('Configuration manquante (ajaxUrl)');
			}

			const response = await fetch(ajaxUrl, {
				method: 'POST',
				body: formData
			});

			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}

			const result = await response.json();

			if (result.success) {
				this.showMessage('Inscription réussie ! Nous vous contacterons bientôt.', 'success');
				setTimeout(() => {
					this.closeModal();
				}, 3000);
			} else {
				throw new Error(result.data.message || 'Une erreur est survenue.');
			}

		} catch (error) {
			console.error('Erreur inscription:', error);
			this.showMessage(error.message || 'Une erreur est survenue lors de l\'inscription.', 'error');
		} finally {
			this.setLoading(false);
		}
	}

	setLoading(isLoading) {
		if (this.submitButton) {
			this.submitButton.disabled = isLoading;
			this.submitButton.textContent = isLoading ? 'Envoi en cours...' : 'S\'inscrire';
		}
	}

	showMessage(text, type) {
		this.messageContainer.textContent = text;
		this.messageContainer.classList.remove('hidden');

		if (type === 'success') {
			this.messageContainer.classList.add('bg-green-100', 'text-green-700');
		} else {
			this.messageContainer.classList.add('bg-red-100', 'text-red-700');
		}
	}

	resetForm() {
		this.form.reset();
		this.messageContainer.classList.add('hidden');
	}
}
