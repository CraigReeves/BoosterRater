@extends('default')
@section('title', $fund_raiser->name)
@section('content')

    <div class="fundraiser-main-section">
        <h3>{{ $fund_raiser->name }}</h3>
        <div class="fundraiser-stat">
            <span class="fundraiser-stat-name">Average Rating:</span> <span class="fundraiser-stat-value">{{ $fund_raiser->average_rating }}</span>
        </div>
    </div>

    <div class="fundraiser-review-section">
        <h4>Reviews</h4>
        <div class="reviews-body">
            @foreach($ratings as $rating)
                <div class="review">
                    @if(!empty($rating->review))
                        <div class="review-text">{{ $rating->review }}</div>
                    @endif
                    <div class="review-score">{{ $rating->score }} out of 5</div>
                    <div class="review-user">- {{ $rating->user->name }} ({{ $rating->user->email }})</div>
                    <div class="review-date">{{ $rating->created_at->diffForHumans() }}</div>
                </div>
            @endforeach

            {{ $ratings->links() }}
        </div>
    </div>
@endsection



