@extends('default')
@section('script_vars')
    <script>
        window.page.route_create_rating = '{{ route('create_rating') }}';
        window.page.route_get_fundraisers = '{{ route('get_fundraisers') }}';
    </script>
@endsection
@section('title', 'Fundraser Ratings')
@section('content')

    <div v-if="fund_raisers.length > 0" class="fundraiser-list">
        <div class="row no-gutters">
            <div class="col-sm-12">
                <div class="main-list">
                    <div class="row headings">
                        <div class="col-sm-4 heading-name">
                            Name
                        </div>
                        <div class="col-sm-3 heading-rating">
                            Rating
                        </div>
                    </div>

                    <div v-for="fund_raiser in fund_raisers" class="row no-gutters fundraiser-item">
                        <div v-text="fund_raiser.name" class="col-sm-4 fundraiser-title"></div>
                        <div v-html="renderStarRating(fund_raiser.average_rating)" class="col-sm-3 rating"></div>
                        <div class="col-sm-5">
                            <a v-on:click="populateNameField($event, fund_raiser)" href="#">Add Review</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="total_fund_raisers > per_page" class="pagination-links">
            <span v-on:click="prevPage($event)" v-if="page > 1" class="pagination-link"><a href="#">&laquo Prev</a></span>
            <span v-on:click="nextPage($event)" v-if="page < num_pages" class="pagination-link"><a href="#">Next &raquo</a></span>
        </div>
    </div>

    <div class="review-section">
        <h2>Leave A Review</h2>
        <div v-if="congrats" class="alert alert-success">
            Your review has been submitted!
        </div>
        <form v-on:submit="submitReview($event)" class="review-form">
            <div class="form-group">
                <label for="fund_raiser_name">Fundraiser Name</label>
                <input v-model="fund_raiser_name" name="fund_raiser_name" class="form-control" type="text">
                <div v-text="errors.fund_raiser_name" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="fund_raiser_name">Your Name</label>
                <input v-model="name" name="name" class="form-control" type="text">
                <div v-text="errors.name" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input v-model="email" class="form-control" type="email">
                <div v-text="errors.email" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="rating">Rating</label>
                <select v-model="rating" class="form-control" name="rating" id="rating-select">
                    <option value="none">Select Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <div v-text="errors.rating" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="review">Review</label>
                <textarea v-model="review" rows="5"  name="review" class="form-control"></textarea>
            </div>
            <input class="btn btn-primary" value="Send Review" type="submit">
            <div v-text="errors.form" class="error-message mt-2"></div>
        </form>
    </div>
@endsection