<html>
<body>
<form>
	<textarea rows="10" cols="30" id="field"  onKeyPress="handleTyping(event)">
</textarea>

<textarea rows="10" cols="30" id="hiddenfield"  style="display:none">
</textarea>
</form>
<script>
	function handleTyping(e){
    setTimeout(function(){handleTypingDelayed(e)},500);
}

function handleTypingDelayed(e){

    var text = document.getElementById('hiddenfield').value;
    var stars = document.getElementById('hiddenfield').value.length;
    unicode = eval(unicode);
    var unicode=e.keyCode? e.keyCode : e.charCode;

    if ( (unicode >=65 && unicode <=90) 
            || (unicode >=97 && unicode <=122) 
                || (unicode >=48 && unicode <=57) ){
        text = text+String.fromCharCode(unicode);    
        stars += 1;
    }else{
        stars -= 1;
    }

    document.getElementById('hiddenfield').value = text;
    document.getElementById('field').value = generateStars(stars);
}

function generateStars(n){
    var stars = '';
    for (var i=0; i<n;i++){
        stars += '.';
    }
    return stars;
}
</script>
</body>
</html>



  <div id="remove">
                <nav class="inside_nav"> Delete complaint </nav>
                <form class="form" action="Complaints.php" method="post">
                    <table class="info">
                        <tr>
                            <td><input type="text" placeholder="Room number" name="delroom"></td>
                            <td><button>Next</button></td>
                        </tr>
                         <?php if(isset($del_flag)) if($del_flag == "error"): $del_flag = 0; ?><tr><td><span class="error"> *Room not found </span></td></tr> <?php endif; ?>
                    </table>
                </form>
            </div>
            <?php if(isset($del_flag)) if($del_flag == 1): $del_flag = 0; ?>
            <div id="remove2">
                <nav class="inside_nav"> Choose complaint </nav>
                <?php global $c; ?>
                <form class="form" action="del.php" method="post">
                    <?php $i=1; $j=0; while($i <= $c[3]): ?>
                    <input type="checkbox" name="com" value="c<?php echo $i++; ?>"> <?php echo $c[$j++] ?>
                    <?php endwhile; ?>
                </form>
            </div>
            <?php endif; ?>