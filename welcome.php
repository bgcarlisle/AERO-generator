<div class="aeroCentredColumn">

     <h2>Start a new AERO diagram</h2>

     <div class="aeroWelcomePane">

          <h3>Choose a tab-delimited text file to upload</h3>

          <form action="<?php echo SITE_URL; ?>edit/">

               <input type="file">

               <button>Upload file</button>

          </form>

          <p>Need help with formatting?</p>

          <button onclick="$('#aeroFormattingInstructions').slideToggle();">Show formatting instructions</button>

          <div id="aeroFormattingInstructions" class="aeroHidden">

               <h3>In Excel or OpenOffice</h3>

               <p>Start by preparing your data set in a spreadsheet programme of your choice.</p>

               <p>The first row of your spreadsheet should have the same headings as the following example. Note that the case <em>is</em> important.</p>

               <table class="aeroTable">

                    <tr>

                         <td>id</td>
                         <td>label</td>
                         <td>year</td>
                         <td>colour</td>
                         <td>shape</td>
                         <td>size</td>
                         <td>border</td>
                         <td>row</td>

                    </tr>

                    <tr>

                         <td>1</td>
                         <td>A</td>
                         <td>2009</td>
                         <td>green</td>
                         <td>circle</td>
                         <td>1.5 cm</td>
                         <td>thick</td>
                         <td>RCC</td>

                    </tr>

                    <tr>

                         <td>2</td>
                         <td>B</td>
                         <td>2010</td>
                         <td>green</td>
                         <td>circle</td>
                         <td>1 cm</td>
                         <td>thick</td>
                         <td>RCC</td>

                    </tr>

                    <tr>

                         <td>3</td>
                         <td>C</td>
                         <td>2013</td>
                         <td>red</td>
                         <td>circle</td>
                         <td>1 cm</td>
                         <td>dashed</td>
                         <td>Melanoma</td>

                    </tr>

               </table>

               <p>Put each node in your diagram on a different row in your table, as in the example above, then export as a tab-delimited text file.</p>

          </div>

     </div>

</div>
