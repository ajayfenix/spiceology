<div class="single-testimonial-slide">
    <div class="single-testimonial-card">
        <?= get_the_post_thumbnail( get_the_ID(), 'bc-small' ); ?>
        <div class="single-testimonial-card-text">
            <span class="quote-mark">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 16"><path d="M8 16V8.519H4.812L8 0H3.826L0 9.174V16h8zm10 0V8.519h-3.188L18 0h-4.174L10 9.174V16h8z"/></svg>
            </span>
            <?= get_the_content( get_the_ID() ); ?>
        </div>
    </div>
</div>