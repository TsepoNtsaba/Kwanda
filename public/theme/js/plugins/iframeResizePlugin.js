$.fn.resizeiframe=function(){
    $(this).load(function(){
        if(!this.contentWindow.document.getElementById("home"))
            var height = $(($(this).contents().find("div"))[0]).height()+50;
        else
            var height = $(this).contents().find("body").height()+50;
        //alert(height);
        $(this).css("height",height+"px");
    });
    $(this).click(function(){
        $(this).height($(this).contents().find("body").height()+50);
    });
};
