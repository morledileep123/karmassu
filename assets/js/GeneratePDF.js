 //btn click print
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
     return false;
    }
 function generatePDF(id) {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById(id);
        // Choose the element and save the PDF for our user.
        html2pdf()
          .from(element)
          .save();
      }