$(document).ready(function(){

    $('#hideQ2').hide();
    $('#hideQ4c').hide();
    $('#hideQ4d').hide();
    $('#hideQ7').hide();
    $('#hideQ8').hide();
    $('#hideQ9').hide();

    $('#q2a').on('change', function(){
      if ($('#q2a').val() != 0) {
        $('#hideQ2').show(500);
      } else {
        $('#hideQ2').hide(500);
      }
    })

    $('input[name=q4b]').on('change', function(){
      if ($('input[name=q4b]:checked').val() == 'main') {
        $('#hideQ4c').show(500);
      } else {
        $('#hideQ4c').hide(500);
        $('#hideQ4d').hide(500);
      }
    })

    $('input[name=q4c]').on('change', function(){
      if ($('input[name=q4c]:checked').val() == 'oui') {
        $('#hideQ4d').show(500);
      } else {
        $('#hideQ4d').hide(500);
      }
    })

    $('input[name=q7a]').on('change', function(){
      if ($('input[name=q7a]:checked').val() == 'oui') {
        $('#hideQ7').show(500);
      } else {
        $('#hideQ7').hide(500);
      }
    })

    $('input[name=q8a]').on('change', function(){
      if ($('input[name=q8a]:checked').val() == 'oui') {
        $('#hideQ8').show(500);
      } else {
        $('#hideQ8').hide(500);
      }
    })

    $('input[name=q9a]').on('change', function(){
      if ($('input[name=q9a]:checked').val() == 'oui') {
        $('#hideQ9').show(500);
      } else {
        $('#hideQ9').hide(500);
      }
    })
});
