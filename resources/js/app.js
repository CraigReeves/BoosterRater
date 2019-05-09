
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


const app = new Vue({
    el: '#app',
    data: {
        fund_raiser_name: '',
        name: '',
        email: '',
        rating: 'none',
        review: '',
        congrats: false,
        errors: {
            fund_raiser_name: '',
            name: '',
            email: '',
            rating: '',
            form: ''
        },
        form_validated: false,
        per_page: 8,
        page: 1,
        num_pages: 0,
        fund_raisers: [],
        total_fund_raisers: 0,
        show_fundraiser_link: window.page.route_show_fundraiser
    },
    created: function() {

        // get fundraisers
        axios.get(window.page.route_get_fundraisers, {params: {per_page: this.per_page, page: this.page}})
            .then((result) => {
                this.fund_raisers = result.data.fund_raisers;
                this.num_pages = result.data.num_pages;
                this.total_fund_raisers = result.data.num_found;
            })
            .catch((err) => {
                alert(err);
            })
    },
    methods: {

        submitReview: async function(event) {
            event.preventDefault();

            // validate form
            this.validateForm();

            // once form is validated, save rating
            if (this.form_validated) {

                const result = await axios.post(window.page.route_create_rating, {
                    fund_raiser_name: this.fund_raiser_name.trim(),
                    name: this.name.trim(),
                    email: this.email.trim(),
                    rating: this.rating,
                    review: this.review.trim(),
                });

                if (result.data.response === "ok") {

                    this.loadFundRaisers();
                    this.showCongratsMessage();
                    this.resetForm();

                } else {
                    // form failed to save. Display error message.
                    this.errors.form = result.data.message;
                    setTimeout(() => this.errors.form = '', 3000)
                }
            }
        },

        populateNameField(e, fund_raiser) {
            this.fund_raiser_name = fund_raiser.name;
        },

        loadFundRaisers() {
            axios.get(window.page.route_get_fundraisers, {params: {per_page: this.per_page, page: this.page}})
                .then((result) => {
                    this.fund_raisers = result.data.fund_raisers;
                    this.num_pages = result.data.num_pages;
                    this.total_fund_raisers = result.data.num_found;
                })
                .catch((err) => {
                    alert(err);
                })
        },

        renderStarRating(rating) {
            if (rating < 1.5) {
                return `<span class="fa fa-star"></span><span class="rating-text">(${rating})</span>`;
            }
            if (rating >= 1.5 && rating < 2) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star-half"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 2 && rating < 2.5) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 2.5 && rating < 3) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star-half"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 3 && rating < 3.5) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 3.5 && rating < 4) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star-half"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 4 && rating < 4.5) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 4.5 && rating < 5) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star-half"></span><span class="rating-text">(${rating})</span>`
            }
            if (rating >= 5) {
                return `<span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span><span class="rating-text">(${rating})</span>`
            }
        },

        validateForm: function() {
            this.clearErrors();

            // keep track of if there are errors
            let thereAreErrors = false;

            if (!this.fund_raiser_name.trim()) {
                this.errors.fund_raiser_name = 'Please provide the name of the fundraiser.';
                thereAreErrors = true;
            }

            if (!this.name.trim()) {
                this.errors.name = 'Please provide your name.';
                thereAreErrors = true;
            }

            if (!this.email.trim()) {
                this.errors.email = 'Please provide a valid email.';
                thereAreErrors = true;
            }

            if (this.rating === "none") {
                this.errors.rating = 'Please provide a rating for this fundraiser.';
                thereAreErrors = true;
            }

            // if there are no errors, form will be validated
            if (!thereAreErrors) {
                this.form_validated = true;
            }
        },

        clearErrors: function() {
            this.errors.name = '';
            this.errors.fund_raiser_name = '';
            this.errors.email = '';
            this.errors.rating = '';
            this.errors.form = '';
        },

        resetForm: function() {

            this.rating = 'none';
            this.fund_raiser_name = '';
            this.review = '';
            this.form_validated = false;
        },

        showCongratsMessage: function() {

            this.congrats = true;
            setTimeout(() => this.congrats = false, 3000);
        },

        nextPage: function(e) {
            e.preventDefault();
            this.page++;
            this.loadFundRaisers();
        },

        prevPage: function(e) {
            e.preventDefault();
            this.page--;
            this.loadFundRaisers();
        }
    }
});
