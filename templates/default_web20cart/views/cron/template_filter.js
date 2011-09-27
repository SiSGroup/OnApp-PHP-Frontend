$(document).ready(function() {
   $('#filter').change(function(){
       var id = $(this).find(':selected')[0].id
       var command = $("#cron_command").val()

       $(".button").click()
       
       $("#cron_command").val(command)
       $("#filter option:[id="+ id +"]").attr('selected', 'selected');

       $("input:[type='hidden'][id^='cron']").attr('value', '*')
       
       if ( id == 'common_settings') {
           $("select:[id!='filter']").removeAttr("disabled")
       }
       else {
           switch (id) {
               case 'every_minute':
                   break
               case 'once_a_day':
                   var minute_value = $("#cron_minute option[id='min_0']").val()
                   $("#cron_minute_hidden").val(minute_value)
                   $("#cron_minute option[id='min_0']").attr("selected", "selected")

                   var hour_value = $("#cron_hour option[id='hr_0']").val()
                   $("#cron_hour_hidden").val(hour_value)
                   $("#cron_hour option[id='hr_0']").attr("selected", "selected")
                   break
               case 'once_an_hour':
                   minute_value = $("#cron_minute option[id='min_0']").val()
                   $("#cron_minute_hidden").val(minute_value)
                   $("#cron_minute option[id='min_0']").attr("selected", "selected")
                   break
               case 'twice_an_hour':
                   $("#cron_minute_hidden").val('0.30')
                   $("#cron_minute option[id='min_0']").attr("selected", "selected").text('0.30')
                   break
               case 'twice_a_day':
                   $("#cron_hour_hidden").val('0.12')
                   $("#cron_hour option[id='hr_0']").attr("selected", "selected").text('0.12')
                   break
               case 'once_a_month':
                   minute_value = $("#cron_minute option[id='min_0']").val()
                   $("#cron_minute_hidden").val(minute_value)
                   $("#cron_minute option[id='min_0']").attr("selected", "selected")
                   
                   hour_value = $("#cron_hour option[id='hr_0']").val()
                   $("#cron_hour_hidden").val(hour_value)
                   $("#cron_hour option[id='hr_0']").attr("selected", "selected")

                   var day_value = $("#cron_day option[id='d_1']").val()
                   $("#cron_day_hidden").val(day_value)
                   $("#cron_day option[id='d_1']").attr("selected", "selected")
                   break
               case 'every_five_minute':
                   $("#cron_minute_hidden").val('*/5')
                   $("#cron_minute option[id='min_0']").attr("selected", "selected").text('*/5')
                   break
               case 'once_a_year':
                   $("#cron_minute_hidden").val('0')
                   $("#cron_minute option[id='min_0']").attr("selected", "selected").text('0')

                   $("#cron_hour_hidden").val('0')
                   $("#cron_hour option[id='hr_0']").attr("selected", "selected").text('0')

                   $("#cron_day_hidden").val('1')
                   $("#cron_day option[id='d_1']").attr("selected", "selected").text('1')

                   $("#cron_month_hidden").val('1')
                   $("#cron_month option[id=mon_1]").attr("selected", "selected").text('1')
                   break
           }

           $("select:[id!='filter']").attr("disabled", "disabled")
       }
   })
 });