$(document).ready(function () {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim();
    if (all) {
      return $(el);
    } else {
      return $(el).get(0);
    }
  };

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      $(el).each(function () {
        $(this).on(type, listener);
      });
    } else {
      $(el).on(type, listener);
    }
  };

  /**
   * Easy on scroll event listener
   */
  const onscroll = (el, listener) => {
    $(el).scroll(listener);
  };

  /**
   * Sidebar toggle
   */
  if (select(".toggle-sidebar-btn")) {
    on("click", ".toggle-sidebar-btn", function (e) {
      $("body").toggleClass("toggle-sidebar");
    });
  }

  /**
   * Search bar toggle
   */
  if (select(".search-bar-toggle")) {
    on("click", ".search-bar-toggle", function (e) {
      $(".search-bar").toggleClass("search-bar-show");
    });
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = $("#navbar .scrollto");
  const navbarlinksActive = () => {
    let position = $(window).scrollTop() + 200;
    navbarlinks.each(function () {
      let navbarlink = $(this);
      if (!navbarlink.hash) return;
      let section = $(navbarlink.hash);
      if (!section.length) return;
      if (
        position >= section.offset().top &&
        position <= section.offset().top + section.outerHeight()
      ) {
        navbarlink.addClass("active");
      } else {
        navbarlink.removeClass("active");
      }
    });
  };
  $(window).on("load", navbarlinksActive);
  onscroll(document, navbarlinksActive);

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = $("#header");
  if (selectHeader.length) {
    const headerScrolled = () => {
      if ($(window).scrollTop() > 100) {
        selectHeader.addClass("header-scrolled");
      } else {
        selectHeader.removeClass("header-scrolled");
      }
    };
    $(window).on("load", headerScrolled);
    onscroll(document, headerScrolled);
  }

  /**
   * Back to top button
   */
  let backtotop = $(".back-to-top");
  if (backtotop.length) {
    const toggleBacktotop = () => {
      if ($(window).scrollTop() > 100) {
        backtotop.addClass("active");
      } else {
        backtotop.removeClass("active");
      }
    };
    $(window).on("load", toggleBacktotop);
    onscroll(document, toggleBacktotop);
  }

  /**
   * Initiate tooltips
   */
  $('[data-bs-toggle="tooltip"]').tooltip();

  /**
   * Initiate Bootstrap validation check
   */
  $(".needs-validation").on("submit", function (event) {
    var form = $(this)[0];
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }

    form.classList.add("was-validated");
  });

  /**
   * Initiate Datatables
   */
  let options = { responsive: true };
  $(".datatable").each(function () {
    new DataTable($(this).get(0), options);
  });

  /**
   * List of provinces
   */
  $.ajax({
    url: "assets/includes/fetch.php",
    type: "POST",
    data: {
      get_provinces: true,
    },
    dataType: "json",
    success: function (response) {
      var len = response.length;
      for (var i = 0; i < len; i++) {
        var id = response[i]["id"];
        var province = response[i]["province"];
        $("#province_id").append(
          "<option value='" + id + "'>" + province + "</option>"
        );
      }
    },
  });

  /**
   * List of business names
   */
  $("#business_name").on("keydown", function () {
    var province_id = $("#province_id").val();
    var business_name = $(this).val();
    if (business_name !== "") {
      $.ajax({
        url: "assets/includes/fetch.php",
        method: "POST",
        data: {
          province_id: province_id,
          business_name: business_name,
          get_business_names: true,
        },
        dataType: "json",
        success: function (response) {
          var len = response.length;
          $("#suggestions").empty();
          for (var i = 0; i < len; i++) {
            var business_name = response[i]["business_name"];
            $("#suggestions").append(
              '<li class="list-group-item" style="cursor:pointer" onclick="business_name.value = \'' + business_name + '\';suggestions.innerHTML = \'\'">' + business_name + '</li>'
            );
          }
        },
      });
    } else {
      $("#suggestions").empty();
    }
  });
});
