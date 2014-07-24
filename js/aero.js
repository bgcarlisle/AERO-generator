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

function aeroUpdateRow ( rid, col, newval ) {

     $.ajax ({
          url: aerourl + 'edit/updaterow.php',
          type: 'post',
          data: {
               rowid: rid,
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

function aeroUpdateDiagram ( did, col, newval ) {

     $.ajax ({
          url: aerourl + 'edit/updatediagram.php',
          type: 'post',
          data: {
               diagram: did,
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

function aeroDeleteNode ( nid ) {

     $.ajax ({
          url: aerourl + 'edit/deletenode.php',
          type: 'post',
          data: {
               node: nid
          },
          dataType: 'html'
     }).done ( function (html) {

          $('#aeroEditorTableContainer').html(html);

     });

}

function aeroDeleteRow ( rid ) {

     $.ajax ({
          url: aerourl + 'edit/deleterow.php',
          type: 'post',
          data: {
               rowid: rid
          },
          dataType: 'html'
     }).done ( function (html) {

          $('#aeroEditorTableContainer').html(html);

     });

}
