/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    //All check boxes are unchecked as default
    $("input[type=checkbox]").prop("checked", false);
    $("#checkAll").click(function(){
        if(this.checked) {
            $('.checkBox').each(function() { 
                this.checked = true;               
            });
        } else {
            $('.checkBox').each(function() { 
                this.checked = false;  
            });
        }
    });

//    $("input[type='number']").change(function(){
////        alert(this.id + "Change to " + this.value);
//           $.ajax({
//                type: "POST",
//                url: "/app_dev.php/numAjax",
//                data: {
//                  num: this.value,
//                  id: this.id,
//                },
//                dataType: "json",
//                success: function(response) {
//                    console.log(response);
//                    $("#sub").html();
//                }
//            });
//    });
});

