<!DOCTYPE html>
<head>
  <title>Laravel 8 Pusher Notification Example Tutorial - XpertPhp</title>
  <h1>Laravel 8 Pusher Notification Example Tutorial</h1>
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  @section('script')
    <script src="/js/app.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    {{--  listen  --}}
    <script type="text/javascript">     
      const applicationstatus = "{{$application->status}}";
      window.Echo.channel(`notify-application-status-change-to-${applicationstatus}`).listen("NotifyApplicationStatusChange", (data) => {
          alert(data);
          console.log(data);
          // $( document ).ready(function(){
          //     let newUserDiv = $("<div></div>").addClass("bg-white shadow-profile mx-auto w-56 h-20 flex justify-between items-center space-x-2 px-2 py-1 rounded-lg");                    
          //     newUserDiv.attr("id", `user-${data.user_data.id}`);
          //     let newUserImageDiv = $("<div></div>").addClass("flex justify-center items-center h-full w-1/5");
              
          //     const imageAvatar = data.user_data.avatar;
          //     const isFile = data.user_data.isFile;
          //     console.log(imageAvatar, isFile);
          //     let imageUrl;
          //     if(imageAvatar == undefined){
          //         imageUrl = `{{asset('images/default_profpic.png')}}`;
          //     } else {
          //         if(isFile){
          //             imageUrl = `{{ asset('storage/user/avatar/${imageAvatar}') }}`;
          //         }else{
          //             imageUrl = `{{ '${imageAvatar}' }}`;
          //         }
          //     }
          //     // console.log(imageAvatar);
          //     $newUserImage = $(`<img src='${imageUrl}'></img>`).addClass("rounded-full h-10");
          //     $newUserName = $("<h1></h1>").addClass("text-green-nav text-xl font-bold w-4/5").html(data.user_data.name);

          //     newUserImageDiv.append($newUserImage);
          //     newUserDiv.append(newUserImageDiv);
          //     newUserDiv.append($newUserName);

          //     $("#card-user-container").prepend(newUserDiv);
              
          //     let playerCount = $("#player-count").text();
          //     playerCount = parseInt(playerCount) + 1;
          //     $("#player-count").html(playerCount);
          // });
    </script>
  @endsection
</head>