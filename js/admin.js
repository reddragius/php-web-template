$("#pages").sortable({
    update: () => {
        const sortedIDs = $( "#pages" ).sortable( "toArray" );
        console.log(sortedIDs);

        $.ajax({
            url: "admin.php",
            data: {
                "orderPage" : sortedIDs,
            }
        })
    }
});