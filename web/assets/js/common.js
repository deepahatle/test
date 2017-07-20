$(function(){
    if(TWIG.profileComplete == false){
        swal({
            type: "warning",
            title: "Profile Incomplete!",
            text: "You need to complete your profile before you can start.",
            confirmButtonText: "Edit Profile",
            confirmButtonColor: "#5c90d2",
            closeOnConfirm: false
        },
        function(){
            window.location = TWIG.edit_lab_render;
        });
    }
    if(TWIG.userProfileComplete == false){
        swal({
            type: "warning",
            title: "Change Password!",
            text: "Please change your password before continuing.",
            confirmButtonText: "Change Password",
            confirmButtonColor: "#5c90d2",
            closeOnConfirm: false
        },
        function(){
            window.location = TWIG.change_password;
        });
    }
});