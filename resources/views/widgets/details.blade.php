<div class="details">
  <div class="details-list">
    @foreach($details as $item)
      <div class="details-list-block @if(($loop->iteration % 2) === 0) details-list-block-revert @endif">
        <div class="details-list-block-title">
          <div class="details-list-block-title-background">
            {!! sprintf("%02d", $loop->iteration) !!}
          </div>
          <div class="details-list-block-title-text">
              {!! $item['title'] !!}
          </div>
        </div>
        <div class="details-list-block-content">
          <div class="details-list-block-content-image"
               style='background-image: url("{!! $item['background'] !!}")'>

          </div>
          <div class="details-list-block-content-text">
            {!! $item['information'] !!}
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
