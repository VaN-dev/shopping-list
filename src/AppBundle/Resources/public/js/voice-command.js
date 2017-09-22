function send(text){
    $.get(
        '/app_dev.php/api/resolve-speech?q=' + text,
        function(response){
            if (response.speech) {
                prepareResponse(response.speech);
            }
            $('#response').text(response.action);

            if (response.success === true) {
                if (response.params && response.params.action == "redirect") {
                    window.location.href = response.params.value;
                } else if (response.action == "suggest-recipes") {
                    console.log(response);
                    fetchRandomRecipes();
                } else if (response.action == "recipe.choose") {
                    var ids = [];
                    console.log(response.params);
                    // $.each(response.params, function (i, item) {
                    //     ids.push(item.id);
                    // });
                    ids.push(response.params.id);

                    addRecipesToShoppingList(ids);
                } else if (response.action == "shopping-list.save") {
                    console.log('submitting');
                    $('#form-shoppinglist').submit();
                }
            }
        }
    );
}