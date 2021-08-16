
var js = {
    window_load : function() {
    },
    document_ready : function() {
      js.cookieDialog();
      js.datepicker();
      js.select();
      js.modal();
      
    },
    cookieDialog(){
      setTimeout(function(){$('#allow_cookies').fadeIn(400);}, 3000);
    },
    initDriverMap: function(){
      alert("init driver")
    },
    initializeGoogle:function(){
      var input = document.getElementById('txtlocation');
      if(input){
        var autocomplete = new google.maps.places.Autocomplete(input, {  });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();

            IsplaceChange = true;
        });
      }
      
    },
    notify:function(text, type){
      var color="#4fd69c";
      var autoHideDelay=5000;
      var autoHide= true;

      if(type=="warning"){
        color="#fc7c5f";
      }else if(type=="primary"){
        color="#37d5f2";
        autoHide=false;
      }
      $.notify.addStyle('custom', {
          html: "<div><strong><span data-notify-text /></strong></div>",
          classes: {
              base: {
                  "position": "relative",
                  "margin-bottom": "1rem",
                  "padding": "1rem 1.5rem",
                  "border": "1px solid transparent",
                  "border-radius": ".375rem",

                  "color": "#fff",
                  "border-color": color,
                  "background-color": color,
              },
              success: {
                  "color": "#fff",
                  "border-color": color,
                  "background-color": color,
              }
          }
          });

          $.notify(text,{
              position: "bottom right",
              style: 'custom',
              className: 'success',
              autoHideDelay: autoHideDelay,
              autoHide:autoHide,
              z_index: 200051
          }
      );
    },   
    modal: function (){
      $('.modal-content').resizable({
        //alsoResize: ".modal-dialog",
        minHeight: 300,
        minWidth: 300
      });
      $('.modal-dialog').draggable();
  
      $('#myModal').on('show.bs.modal', function() {
        $(this).find('.modal-body').css({
          'max-height': '100%'
        });
      });
    },
    select : function(){
      $("select").not(".noselecttwo").each(function( $pos ){
        var $this = $(this);
        if (!$this.hasClass("select2init")){
          $settings = {};
          $this.addClass("select2init");
          
          $('.select2').addClass('form-control');
          $('.select2-selection').css('border','0');
          $('.select2-selection__arrow').css('top','10px');
          $('.select2-selection__rendered').css('color','#8898aa');

          var $ajax = $this.attr("data-feed");
          if (typeof $ajax !== typeof undefined && $ajax !== false){
            $settings.ajax = { url : $ajax, dataType: 'json' }
          }
  
          if (typeof($this.attr("placeholder")) != "undefined"){
            $settings.placeholder = $this.attr("placeholder");
            $settings.id = "-1";
          }
  
          $this.select2($settings);
        }
      });
    },


    datepicker : function(){
       
        $(".daterange").each(function(){
          var $this = $(this);
          var $end = moment();
          var $start = moment().subtract(1, 'month');
          $this.daterangepicker({
            autoUpdateInput: false,
            locale: {cancelLabel: 'Clear'},
            buttonClasses : "datepicker-btn",
            startDate : $start,
            endDate: $end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'This year': [moment().startOf('year'), moment()],
               'Last year': [moment().startOf('year').subtract(1, 'years'), moment().subtract(1, 'year')]
            }
          });
          $this.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
          });
          $this.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
          });
        });
      }
}

var $ = jQuery.noConflict();$(window).on("load",function(){js.window_load();});$(document).ready(function() {js.document_ready();});
Number.prototype.pad = function(size) {
  var s = String(this);
  while (s.length < (size || 2)) {s = "0" + s;}
  return s;
}
$.randomID = function(){ return ( Math.random().toString(36).substring(2) ) };
$.tpl = function(template, data){
  return template.replace(/\{([\w\.]*)\}/g, function(str, key) {
    var keys = key.split("."), v = data[keys.shift()];
    for (var i = 0, l = keys.length; i < l; i++) v = v[keys[i]];
    return (typeof v !== "undefined" && v !== null) ? v : "";
  });
};
$.expr[':'].contains = function(a, i, m) { return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0; };