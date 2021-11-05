<?php
?>

<style>
    footer{ 
        width: 100%; padding-top: -100px; bottom: 0;
        background-color: #E9CCD3;
        position: absolute;
    }
    
    .image{
        height: 3em; padding: 0.75em 0 0 10%;
        float: left;
    }
    
    .text1{
        padding: 1em 0 1em 1em;
        font-size: 0.75em; display: inline-block; vertical-align: middle;
    }
    
    .text2{
        padding: 1em 10% 1em 0;
        font-size: 1.05em; display: inline-block; float: right;
    }
    
    /* RESPONSIVE */
    @media screen and (max-width: 800px){        
        .image{
            padding: 1em 0 0 5%;
        }
        
        .text1{
            width: 70%; padding: 0.75em 0 0.75em 0.75em;
            font-size: 0.5em; 
        }
        
        .text2{
            padding: 1.05em 5% 1em 0;
        }
    }
</style>


<footer>
    <div id="footer">
  		<img class="image" src="./pic/academia_sinica.png">
        <div class="text1">
            著作權©中研院統計科學研究所. 版權所有.<br>
		    Copyright© Institute of Statistical Science, Academia Sinica. All rights reserved.
        </div>
        <div class="text2">
            <button style="border: none; background-color: #2C317C">
            <i class="fab fa-facebook-f" style="padding: 0.1em; color: #FFFFFF" onclick="window.open('https://***')"></i>
            </button>
        </div>
    </div>
</footer>
