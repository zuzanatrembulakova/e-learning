<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <title>Forum</title>
</head>
<body>
    <h1>Forum</h1>

            <div>
                <a href="forum-question.php"><h5>Sara Bertova</h5></a>
                <p>Nov 22nd 2021</p>
                <div>
                    Preco musime odovzdat vsetko v jeden den?
                </div>
            </div>

            <div>
                <h5>Sara Bertova</h5>
                <p>Nov 22nd 2021</p>
                <div>
                    Preco musime odovzdat vsetko v jeden den?
                </div>
            </div>

            <div>
                <h5>Sara Bertova</h5>
                <p>Nov 22nd 2021</p>
                <div>
                    Preco musime odovzdat vsetko v jeden den?
                </div>
            </div>

            
            
            <div id="your-question">
            <h2>What do you want to ask?</h2>
                <form onsubmit="return false">
                    <label>Ask</label>
                    <textarea name="question" placeholder="Enter your question"></textarea>
                    <button onclick="()">Send question</button>
                </form>
            </div>

            <button onclick="displayInput()" type="button" class="plus_button frog_position plusSign" id="frog_btn">
                    &#43;
            </button>

            <script src="script.js"></script>
     

</body>
</html>