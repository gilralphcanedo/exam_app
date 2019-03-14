$( document ).ready(function() {

  $('[data-toggle="tooltip"]').tooltip();
  $(".table-wrap").each(function() {
    var nmtTable = $(this);
    var nmtHeadRow = nmtTable.find("thead tr");
    nmtTable.find("tbody tr").each(function() {
      var curRow = $(this);
      for (var i = 0; i < curRow.find("td").length; i++) {
        var rowSelector = "td:eq(" + i + ")";
        var headSelector = "th:eq(" + i + ")";
        curRow.find(rowSelector).attr('data-title', nmtHeadRow.find(headSelector).text());
      }
    });
  });

  $("#flash-alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#flash-alert").slideUp(500);
  });

  $('.form-control-required').on('change', function(){
    if ( $(this).hasClass('border-danger') && $(this).val() != "" ) { /* if has red border and is not empty */
        $(this).toggleClass('border-danger');
        $(this).parent().find('.error.text-danger').removeClass('opacity-1');
    }
    else if ( !$(this).hasClass('border-danger') && $(this).val() == "" ){ /* if has no red border and is empty */
        $(this).toggleClass('border-danger');
        $(this).parent().find('.error.text-danger').addClass('opacity-1');
    }
  });

  // multi step
  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
      var $target = $(e.target);
      console.log($target)
      if ($target.parent().hasClass('disabled')) {
          return false;
      }
  });
  $(".next-step").click(function (e) {
      var $active = $('.questions-tab-wrapper .question-tabs li a.active');
      $active.parent().next().find('a[data-toggle="tab"]').removeClass('disabled');
      nextTab($active);
  });
  // $(".prev-step").click(function (e) {
  //     var $active = $('.questions-tab-wrapper .question-tabs li a.active');
  //     prevTab($active);
  // });
  

});

function nextTab(elem) {
  console.log($(elem).parent().next().html());
  $(elem).parent().next().find('a[data-toggle="tab"]').click();
}
// function prevTab(elem) {
//   console.log($(elem).prev());
//   $(elem).parent().prev().find('a[data-toggle="tab"]').click();
// }