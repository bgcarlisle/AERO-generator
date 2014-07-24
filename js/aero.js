function aeroUpdateNode ( nid, col, newval ) {

     $.ajax ({
		url: aerourl + 'edit/updatenode.php',
		type: 'post',
		data: {
			node: nid,
               column: col,
			value: $('#' + newval).val()
		},
		dataType: 'html'
	}).done ( function (html) {

		if ( html.search('1') == 0 ) {

               $('#' + newval).css('background-image', 'url(' + aerourl + 'images/check.png)');

               setTimeout ( function () {

				$('#' + newval).css('background-image', 'none');

			}, 1000);

          } else {

               alert (html);

          }

	});

}

function aeroMoveRow ( rid, dir ) {

     $.ajax ({
          url: aerourl + 'edit/moverow.php',
          type: 'post',
          data: {
               rowid: rid,
               direction: dir
          },
          dataType: 'html'
     }).done ( function (html) {

          $('#aeroEditorTableContainer').html(html);

     });

}
