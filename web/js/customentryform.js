$(document).ready(function () {


   
   

    /* Add ledger row */
    $(document).on('click', '#add-row', function(event) 
    {
        event.preventDefault();   
    });


    /* Dr - Cr dropdown changed */
    $(document).on('change', '.dc-dropdown', function() {
       
        if ($(this).parent().parent().next().children().children().val() == '') {
            return;
        }
        if ($(this).prop('value') == "D") {
            $(this).parent().parent().next().next().next().children().children().prop('value', "");
            $(this).parent().parent().next().next().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().children().children().prop('disabled', '');
        } else {
            
            $(this).parent().parent().next().next().children().children().prop('value', "");
            $(this).parent().parent().next().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().next().children().children().prop('disabled', '');
        }
       
    });


    /* Ledger dropdown changed */
    $(document).on('change', '.ledger-dropdown', function() {
        if ($(this).val() == '') {
            /* Reset and diable dr and cr amount */
            $(this).parent().parent().next().children().children().prop('value', "");
            $(this).parent().parent().next().next().children().children().prop('value', "");
            $(this).parent().parent().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().next().next().next().html('');
        } else {
            /* Enable dr and cr amount and trigger Dr/Cr change */
            $(this).parent().parent().next().children().children().prop('disabled', '');
            $(this).parent().parent().next().next().children().children().prop('disabled', '');
            $(this).parent().parent().prev().children().children().trigger('change');

            //$(this).parent().parent().next().next().next().next().html('3');
            var thisRow=$(this);
            var ledger_id=$(this).val();
            //Setting CL Balance
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl.'/ledgers/closingbalance' ?>',
                data: 'id=' + ledger_id,
                dataType: 'json',
                success: function(data)
                {
                     thisRow.parent().parent().next().next().next().next().next().html(data);
                }
            });
        }
        /* Trigger dr and cr change */
       
        $(".cr-amount").trigger('change');
        $(".dr-amount").trigger('change');
       
    });


      
    $(document).on('change', '.dr-amount', function() {
        var drTotal = 0;
        $("table tr .dr-amount").each(function() {
            var curDr = $(this).prop('value')
            curDr = parseFloat(curDr);
            if (isNaN(curDr))
                curDr = 0;
            drTotal += curDr;
        });
        $("table tr #dr-total").text(drTotal);
        var crTotal = 0;
        $("table tr .cr-amount").each(function() {
            var curCr = $(this).prop('value')
            curCr = parseFloat(curCr);
            if (isNaN(curCr))
                curCr = 0;
            crTotal += curCr    ;
        });
        $("table tr #cr-total").text(crTotal);

        if(crTotal != drTotal || crTotal == 0)
        {
            $("table #difference").css("background-color", "#FBEFEF");
             $("#final-submit").prop('disabled','disabled');
        }
        else
        {
            $("table #difference").css("background-color", "white");
            $("#final-submit").prop('disabled','');
        }

        $difference=crTotal - drTotal;
         if($difference < 0)
        {        
            $("table tr #dr-diff").text('');
            $("table tr #cr-diff").text(Math.abs($difference));

        }
         else if($difference > 0)
        {
            $("table tr #cr-diff").text('');
            $("table tr #dr-diff").text(Math.abs($difference));
        }
        else
        {
            $("table tr #cr-diff").text('');
            $("table tr #dr-diff").text('');
        }

    });

      $(document).on('change', '.cr-amount', function() {

        var drTotal = 0;
        $("table tr .dr-amount").each(function() {
            var curDr = $(this).prop('value')
            curDr = parseFloat(curDr);
            if (isNaN(curDr))
                curDr = 0;
            drTotal += curDr;
        });
        $("table tr #dr-total").text(drTotal);
        var crTotal = 0;
        $("table tr .cr-amount").each(function() {
            var curCr = $(this).prop('value')
            curCr = parseFloat(curCr);
            if (isNaN(curCr))
                curCr = 0;
            crTotal += curCr;
        });
        $("table tr #cr-total").text(crTotal);
        if(crTotal != drTotal || crTotal == 0)
        {
            $("table #difference").css("background-color", "#FBEFEF");
            $("#final-submit").prop('disabled','disabled');
        }
        else
        {
            $("table #difference").css("background-color", "white");
             $("#final-submit").prop('disabled','');
        }
         $difference=crTotal - drTotal;
        if($difference < 0)
        {        
            $("table tr #dr-diff").text('');
            $("table tr #cr-diff").text(Math.abs($difference));
        }
        else if($difference > 0)
        {
            $("table tr #cr-diff").text('');
             $("table tr #dr-diff").text(Math.abs($difference));
        }
         else
        {
            $("table tr #cr-diff").text('');
            $("table tr #dr-diff").text('');
        }
       

    });



$('.ledger-dropdown').trigger('change');
 $(".cr-amount").trigger('change');


});