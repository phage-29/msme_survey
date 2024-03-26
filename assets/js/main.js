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
   * ajax form
   */
  $(".ajax-form").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "Loading",
      html: "Please wait...",
      allowOutsideClick: false,
      didOpen: function () {
        Swal.showLoading();
      },
    });

    var formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "assets/components/includes/process.php",
      data: formData,
      dataType: "json",
      success: function (response) {
        setTimeout(function () {
          Swal.fire({
            icon: response.status,
            title: response.message,
            showConfirmButton: false,
            timer: 1000,
          }).then(function () {
            if (response.redirect) {
              window.location.href = response.redirect;
            }
            if (response.reload) {
              window.reload();
            }
          });
        }, 1000);
      },
    });
  });

  $("#privacy-form").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "assets/components/includes/process.php",
      data: formData,
      dataType: "json",
      success: function (response) {
        $("#privacyModal").modal("hide");
      },
    });
  });

  $("#comments-form").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "assets/components/includes/process.php",
      data: formData,
      dataType: "json",
      success: function (response) {
        $("#suggestionsModal").modal("hide");
        $("#scf-form").submit();
      },
    });
  });

  $("#sfa-form").submit(function (e) {
    e.preventDefault();
    // Swal.fire({
    //   title: "Loading",
    //   html: "Please wait...",
    //   allowOutsideClick: false,
    //   didOpen: function () {
    //     Swal.showLoading();
    //   },
    // });

    $.ajax({
      type: "POST",
      url: "assets/components/includes/process.php",
      data: {
        ref: $("#ref").val(),
        sfa_complete: "",
      },
      dataType: "json",
      success: function (response) {
        window.location.href = response.redirect;
      },
    });
  });

  $("#saa-form").submit(function (e) {
    e.preventDefault();
    // Swal.fire({
    //   title: "Loading",
    //   html: "Please wait...",
    //   allowOutsideClick: false,
    //   didOpen: function () {
    //     Swal.showLoading();
    //   },
    // });

    $.ajax({
      type: "POST",
      url: "assets/components/includes/process.php",
      data: {
        ref: $("#ref").val(),
        saa_complete: "",
      },
      dataType: "json",
      success: function (response) {
        window.location.href = response.redirect;
      },
    });
  });

  $("#scf-form").submit(function (e) {
    e.preventDefault();
    // Swal.fire({
    //   title: "Loading",
    //   html: "Please wait...",
    //   allowOutsideClick: false,
    //   didOpen: function () {
    //     Swal.showLoading();
    //   },
    // });

    $.ajax({
      type: "POST",
      url: "assets/components/includes/process.php",
      data: {
        ref: $("#ref").val(),
        cfa_complete: "",
      },
      dataType: "json",
      success: function (response) {
        window.location.href = response.redirect;
      },
    });
  });

  /**
   * Initiate tooltips
   */
  $('[data-bs-toggle="tooltip"]').tooltip();

  /**
   * List of provinces
   */
  $.ajax({
    url: "assets/components/includes/fetch.php",
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
   * List of industry_cluster
   */
  $.ajax({
    url: "assets/components/includes/fetch.php",
    type: "POST",
    data: {
      get_industry_clusters: true,
    },
    dataType: "json",
    success: function (response) {
      var len = response.length;
      for (var i = 0; i < len; i++) {
        var id = response[i]["id"];
        var industry_cluster = response[i]["industry_cluster"];
        $("#industry_cluster_id").append(
          "<option value='" + id + "'>" + industry_cluster + "</option>"
        );
      }
    },
  });

  /**
   * List of industry_cluster
   */
  $.ajax({
    url: "assets/components/includes/fetch.php",
    type: "POST",
    data: {
      get_major_business_activities: true,
    },
    dataType: "json",
    success: function (response) {
      var len = response.length;
      for (var i = 0; i < len; i++) {
        var id = response[i]["id"];
        var major_business_activity = response[i]["major_business_activity"];
        $("#major_business_activity_id").append(
          "<option value='" + id + "'>" + major_business_activity + "</option>"
        );
      }
    },
  });

  /**
   * List of industry_cluster
   */
  $.ajax({
    url: "assets/components/includes/fetch.php",
    type: "POST",
    data: {
      get_edt_levels: true,
    },
    dataType: "json",
    success: function (response) {
      var len = response.length;
      for (var i = 0; i < len; i++) {
        var id = response[i]["id"];
        var edt_level = response[i]["edt_level"];
        $("#edt_level_id").append(
          "<option value='" + id + "'>" + edt_level + "</option>"
        );
      }
    },
  });

  /**
   * List of industry_cluster
   */
  $.ajax({
    url: "assets/components/includes/fetch.php",
    type: "POST",
    data: {
      get_asset_sizes: true,
    },
    dataType: "json",
    success: function (response) {
      var len = response.length;
      for (var i = 0; i < len; i++) {
        var id = response[i]["id"];
        var asset_size = response[i]["asset_size"];
        $("#asset_size_id").append(
          "<option value='" + id + "'>" + asset_size + "</option>"
        );
      }
    },
  });

  /**
   * List of business names
   */
  $("#province_id").on("change", function () {
    var province_id = $("#province_id").val();
    $.ajax({
      url: "assets/components/includes/fetch.php",
      method: "POST",
      data: {
        province_id: province_id,
        get_business_names: true,
      },
      dataType: "json",
      success: function (response) {
        $("#business_name").autocomplete({
          source: response,
        });
      },
    });
  });
});
