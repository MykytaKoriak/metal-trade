;(function($){
  function getState($root){
    var $form = $root.find('#woo-mk-catalog-form');
    var filters = {};
    $form.find('input[name^="prod_cat["] , input[name^="pa_"]').each(function(){
      var $el = $(this);
      if ($el.is(':checkbox') && !$el.is(':checked')) return;
      var name = $el.attr('name').replace(/\]$/, '').replace(/\[/, '');
      filters[name] = filters[name] || [];
      filters[name].push($el.val());
    });
    var sort = $('#woo-mk-catalog-sort').val();
    var price_min = parseInt($('#woo-mk-catalog-price-min').val(),10);
    var price_max = parseInt($('#woo-mk-catalog-price-max').val(),10);
    var paged = parseInt($root.data('paged')||1,10);
    var per_page = $root.data('perPage');
    if (!per_page && window.woo_mk_catalog_vars) per_page = window.woo_mk_catalog_vars.per_page;
    return {filters:filters, sort:sort, price_min:price_min, price_max:price_max, paged:paged, per_page: per_page || 12};
  }

  function setPriceLabels(){
    var min = parseInt($('#woo-mk-catalog-price-min').val(),10);
    var max = parseInt($('#woo-mk-catalog-price-max').val(),10);
    if (min > max) { var t=min; min=max; max=t; $('#woo-mk-catalog-price-min').val(min); $('#woo-mk-catalog-price-max').val(max); }
    $('#woo-mk-catalog-price-min-val').text(min);
    $('#woo-mk-catalog-price-max-val').text(max);
  }

  function updateURL(params){
    var url = new URL(window.location.href);
    url.search = '';
    Object.keys(params).forEach(function(key){
      var val = params[key];
      if (Array.isArray(val)) {
        val.forEach(function(v){ url.searchParams.append(key+'[]', v); });
      } else if (val !== undefined && val !== null && val !== '') {
        url.searchParams.set(key, val);
      }
    });
    history.pushState({}, '', url.toString());
  }

  function collectParamsFromState(state){
    var params = { sort: state.sort, price_min: state.price_min, price_max: state.price_max, paged: state.paged };
    Object.keys(state.filters||{}).forEach(function(k){ params[k] = state.filters[k]; });
    return params;
  }

  function fetchProducts($root, state){
    var $grid = $('#woo-mk-catalog-grid');
    var $pagination = $('#woo-mk-catalog-pagination');
    $grid.addClass('is-loading');
    var ajax_url = $root.data('ajaxUrl') || (window.woo_mk_catalog_vars && window.woo_mk_catalog_vars.ajax_url);
    var nonce = $root.data('nonce') || (window.woo_mk_catalog_vars && window.woo_mk_catalog_vars.nonce);
    if (!ajax_url || !nonce) {
      // Fallback to full page reload using GET params
      var params = collectParamsFromState(state);
      updateURL(params);
      window.location.assign(window.location.href);
      return;
    }
    $.ajax({
      url: ajax_url,
      method: 'POST',
      dataType: 'json',
      data: {
        action: 'woo_mk_catalog_fetch',
        nonce: nonce,
        filters: state.filters,
        sort: state.sort,
        price_min: state.price_min,
        price_max: state.price_max,
        paged: state.paged,
        per_page: state.per_page
      }
    }).done(function(resp){
      if (resp && resp.success){
        $grid.html(resp.data.grid);
        $pagination.html(resp.data.pagination);
        var params = collectParamsFromState(state);
        updateURL(params);
      }
    }).always(function(){
      $grid.removeClass('is-loading');
    });
  }

  function bind($root){
    // Sorting
    $('#woo-mk-catalog-sort').on('change', function(){ var state=getState($root); state.paged=1; fetchProducts($root, state); });
    // Filters
    $root.on('change', '.woo-mk-catalog__filters input', function(){ var state=getState($root); state.paged=1; fetchProducts($root, state); });
    // Price range labels
    $('#woo-mk-catalog-price-min, #woo-mk-catalog-price-max').on('input change', function(){ setPriceLabels(); var state=getState($root); state.paged=1; fetchProducts($root, state); });
    // Pagination
    $root.on('click', '.woo-mk-catalog__pagination [data-page]', function(e){ e.preventDefault(); var p=$(this).data('page'); var state=getState($root); state.paged=parseInt(p,10)||1; fetchProducts($root, state); });

    // No modal or order flow; click goes to product page
  }

  $(document).ready(function(){
    var $root = $('#woo-mk-catalog-root');
    if(!$root.length) return;
    setPriceLabels();
    bind($root);
  });
})(jQuery);
