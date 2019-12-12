(function($, Drupal, drupalSettings) {
   Drupal.behaviors.insta_block = {
        attach: function (context, settings) {
  if (context == document) {
    var pgName = drupalSettings.insta_block.instagramPosts.page_name;
    var smCol = drupalSettings.insta_block.instagramPosts.sm_columns;
    var mdCol = drupalSettings.insta_block.instagramPosts.md_columns;
    var lgCol = drupalSettings.insta_block.instagramPosts.lg_columns;
    var postCnt = drupalSettings.insta_block.instagramPosts.count - 1;
    var showCpt = drupalSettings.insta_block.instagramPosts.show_caption;

    var baseUrl = drupalSettings.path.baseUrl;

    var instaAPI = baseUrl+"insta/media?user_name="+pgName;

    const Item = ({ link, image, sm_column, md_column, lg_column, caption, likes, comments }) => `
    <div class="${sm_column} ${md_column} ${lg_column}">
      <div class="insta-post">
        <a href="${link}" target="_blank">
          <div class="insta-image">
            <img src="${image}" class="img-responsive">
            <div class="insta-overlay">
              <div class="insta-likes-comments">
                ${likes}&nbsp;&nbsp
                ${comments}
              </div>
            </div>
          </div>
        </a>
        ${caption}
      </div>
    </div>`;
    
    $.getJSON( instaAPI, {
    }).done(function( data ) {
        $.each( data.items, function( i, item ) {
          console.log(item);
          if ( i % smCol == 0 ) {
           $("<div/>", {
              class: "clearfix visible-sm-block"
           }).appendTo("#insta_posts", context);
        }
        if ( i % mdCol == 0 ) {
           $("<div/>", {
              class: "clearfix visible-md-block"
           }).appendTo("#insta_posts", context);
        }
        if ( i % lgCol == 0 ) {
           $("<div/>", {
              class: "clearfix visible-lg-block"
           }).appendTo("#insta_posts", context);
        }

          $([{
            link: (typeof item.link !== 'undefined') ? item.link : "",
            image: (typeof item.images.standard_resolution.url !== 'undefined') ? item.images.standard_resolution.url : "",
            sm_column: (smCol > 0) ? "col-sm-" + 12 / smCol : "col-sm",
            md_column: (mdCol > 0) ? "col-md-" + 12 / mdCol : "col-md",
            lg_column: (lgCol > 0) ? "col-lg-" + 12 / lgCol : "col-lg",
            caption: (showCpt == 1 && typeof item.caption !== 'undefined') ? "<div class='insta-caption'>" + item.caption.text + "</div>" : "",
            likes: (typeof item.likes !== 'undefined') ? "<i class='fa fa-heart' aria-hidden='true'></i>" + item.likes.count : "",
            comments: (typeof item.comments !== 'undefined') ? "<i class='fa fa-comment' aria-hidden='true'></i>" + item.comments.count : "",
          }]
          .map(Item).join('')).appendTo("#insta_posts", context);

          if ( i == postCnt ) {
            return false;
          }
        });
      });
    
  }

    }
  };
})(jQuery, Drupal, drupalSettings);