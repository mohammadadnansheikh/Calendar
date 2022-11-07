<!-- 
     have all the thing except session storage for color setters for the respective dates.
I am working on this.
  Thanks😊 -->

<?php 
if(isset($_POST['func']) && !empty($_POST['func'])){ 
    switch($_POST['func']){ 
        case 'getCalender': 
            getCalender($_POST['year'],$_POST['month']); 
            break; 
        default: 
            break; 
    } 
} 
 
function getCalender($year = '', $month = ''){ 
    $dateYear = ($year != '')?$year:date("Y"); 
    $dateMonth = ($month != '')?$month:date("m"); 
    $date = $dateYear.'-'.$dateMonth.'-01'; 
    $currentMonthFirstDay = date("N",strtotime($date)); 
    $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear); 
    $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 1)?($totalDaysOfMonth):($totalDaysOfMonth + ($currentMonthFirstDay - 1)); 
    $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42; 
     
      $prevMonth = date("m", strtotime('-1 month', strtotime($date))); 
    $prevYear = date("Y", strtotime('-1 month', strtotime($date))); 
    $totalDaysOfMonth_Prev = cal_days_in_month(CAL_GREGORIAN, $prevMonth, $prevYear); 
?> 
    <main class="calendar-contain">
        <div class="flex-container"> 
            <div class="title-bar__month"> 
                <select class="month-dropdown"> 
                    <?php echo getMonthList($dateMonth); ?> 
                </select> 
            </div> 
            <div class="title-bar__year"> 
                <select class="year-dropdown"> 
                   
                    <?php echo getYearList($dateYear); ?> 
                </select> 
            </div> 
            
        </div> 
        
        <div >
        <table class="center">
            <thead>
                <tr>
                    <th>Monday</th>
                    <th>Tuesday</th> 
                    <th>Wednesday</th> 
                    <th>Thursday</th> 
                    <th>Friday</th> 
                    <th>Saturnday</th> 
                    <th>Sunday</th>
                
            </thead>
            <tbody>
            <?php  
                $dayCount = 1; 
                $eventNum = 0; 
                 
                echo '<tr class="calendar__week">'; 
                for($cb=1;$cb<=$boxDisplay;$cb++){ 
                    if(($cb >= $currentMonthFirstDay || $currentMonthFirstDay == 1) && $cb <= ($totalDaysOfMonthDisplay)){ 
                        // Current date 
                        $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount; 
                         
                        // Get number of events based on the current date 
                       
                         
                        // Define date cell color 
                        if(strtotime($currentDate) == strtotime(date("Y-m-d"))){ 
                            echo ' 
                        
                                    <td class="calendar__date">'.$dayCount.'</td>   
                          
                            '; 
                        }elseif($eventNum > 0){ 
                            echo ' 
                               
                                    <td class="calendar__date">'.$dayCount.'</td>  
                             
                            '; 
                        }else{ 
                            echo ' 
                                
                                    <td class="calendar__date">'.$dayCount.'</td> 
                                    
                              
                            '; 
                        } 
                        $dayCount++; 
                    }else{ 
                        if($cb < $currentMonthFirstDay){ 
                            $inactiveCalendarDay = ((($totalDaysOfMonth_Prev-$currentMonthFirstDay)+1)+$cb); 
                        }else{ 
                            $inactiveCalendarDay = ($cb-$totalDaysOfMonthDisplay); 
                        } 
                        echo ' 
                       
                                <td class="calendar__date">'.$inactiveCalendarDay.'</td> 
                                
                         
                        '; 
                    } 
                    echo ($cb%7 == 0 && $cb != $boxDisplay)?'</tr><tr class="calendar__week">':''; 
                } 
                echo '</tr>'; 
            ?>
            </tbody>
        </table>
        </div>
        
         
        <form class="centerfooter" action="" method="post">
            <input style="font-size : 1.8rem; margin:1rem" type="text" name="date" placeholder="Enter Any Date">
            <button type="submit" name="Submit" class="btnenter">Enter</button>
        </form>
       
    </main> 
 
    <script> 
        function getCalendar(target_div, year, month){ 
            $.ajax({ 
                type:'POST', 
                url:'functions.php', 
                data:'func=getCalender&year='+year+'&month='+month, 
                success:function(html){ 
                    $('#'+target_div).html(html); 
                } 
            }); 
        } 
          
        $(document).ready(function(){ 
            $('.month-dropdown').on('change',function(){ 
                getCalendar('calendar_div',$('.year-dropdown').val(), $('.month-dropdown').val(),  $('.btnenter').val()); 
            }); 
            $('.year-dropdown').on('change',function(){ 
                getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val(), $('.btnenter').val()); 
            });
            $('.year-dropdown').on('submit',function(){ 
                getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val(), $('.btnenter').val()); 
            }); 
        }); 
    </script> 
<?php 
} 
 
function getMonthList($selected = ''){ 
    $options = ''; 
    for($i=1;$i<=12;$i++) 
    { 
        $value = ($i < 10)?'0'.$i:$i; 
        $selectedOpt = ($value == $selected)?'selected':''; 
        $options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>'; 
    } 
    return $options; 
} 
 
function getYearList($selected = ''){ 
    $yearInit = !empty($selected)?$selected:date("Y"); 
    $yearPrev = ($yearInit - 5); 
    $yearNext = ($yearInit + 5); 
    $options = ''; 
    for($i=$yearPrev;$i<=$yearNext;$i++){ 
        $selectedOpt = ($i == $selected)?'selected':''; 
        $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>'; 
    } 
    return $options; 
} 

