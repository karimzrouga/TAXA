$('.nav-btn').click(function () {
  $('.links').toggleClass('show');
  $('.open').toggleClass('hide');
  $('.close').toggleClass('hide');
});

$(function () {
  $(document).scroll(function () {
    var $nav = $(".header");
    $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
    var $nav = $(".header-bar");
    $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
  });
});


$('.owl-carousel').owlCarousel({
  loop: false,
  margin: 10,
  nav: false,
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    579: {
      items: 2
    },
    1200: {
      items: 4
    }
  }
});

// magnific popup
$('.owl-carousel').magnificPopup({
  delegate: 'a',
  type: 'image',
  gallery: {
    enabled: false
  }
});

(function () {
  let data = [
    {
      id: 0,
      name: 'john doe',
      text: `Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium id impedit voluptatum
      minus! Eligendi error dolorem harum omnis aperiam mollitia ab sint eius eum facilis saepe assumenda, quis ipsa
      ipsam.`
    },
    {
      id: 1,
      name: 'tom orange',
      text: `Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium id impedit voluptatum
      minus! Eligendi error dolorem harum omnis aperiam mollitia ab sint eius eum facilis saepe assumenda, quis ipsa
      ipsam.`
    },
    {
      id: 2,
      name: 'albert cupid',
      text: `Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium id impedit voluptatum
      minus! Eligendi error dolorem harum omnis aperiam mollitia ab sint eius eum facilis saepe assumenda, quis ipsa
      ipsam.`
    },
    {
      id: 3,
      name: 'dog hugo',
      text: `Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium id impedit voluptatum
      minus! Eligendi error dolorem harum omnis aperiam mollitia ab sint eius eum facilis saepe assumenda, quis ipsa
      ipsam.`
    }]
  $('.reviews-img').click(function () {
    console.log(this);
    $(this).addClass('clicked');
    $('.reviews-img').not(this).removeClass('clicked');
    let id = $(this).attr('data-id');
    console.log(id);
    $('#name').text(data[id].name);
    $('#review').text(data[id].text);
  })

})();