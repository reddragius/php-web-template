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

// protection against accidental page deletion
$("#pages .trash").click((event) => {
    if (confirm("Opravdu chcete danou stránku smazat?") == false)
    {
        // interrupt event
        event.preventDefault();
    }
});