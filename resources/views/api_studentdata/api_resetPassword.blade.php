 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title></title>
     <link rel="stylesheet" href="/css/contact_form.css">
 </head>
 <body>

        <form class="resetForm" id="resetForm">
                <input type="hidden" name="token" value="{{$token}}" id="token">   

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password">
                
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter Your Confirm Password">

               <input type="submit" value="Submit"> 
        </form>    

        <script>         
                document.getElementById('resetForm').addEventListener('submit', function(e){
                    e.preventDefault();

               // let formValue = new FormData(this);
                    let formValue = JSON.stringify({
                        email:document.getElementById('email').value,
                        password:document.getElementById('password').value,
                        password_confirmation:document.getElementById('password_confirmation').value,
                        token:document.getElementById('token').value
                    });

                let formRequest = new XMLHttpRequest();
                formRequest.open('POST','http://127.0.0.1:8000/api/resetpassword',true);
                formRequest.setRequestHeader('Accept','application/json');
                formRequest.setRequestHeader('Content-Type','application/json');

                formRequest.onload = function(){
                    if(formRequest.status === 200) {
                                    alert('Reset Password successfully')                
                                    window.location.href = '/apilogin';
                    }else{
                       console.log('Error:', formRequest.status, formRequest.responseText);
                       //alert('Failed to reset password: ' + formRequest.responseText);
                    }
                }

                formRequest.send(formValue);
                });
            // });
        </script>   
 </body>
 </html>


 
                