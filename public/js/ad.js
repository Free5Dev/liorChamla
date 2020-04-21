$('#add-image').click(function(){
        //Je recupere le numero des futurs champs que je vais créer
        //const index= $('#annonce_images div.form-group').length;
        const index = +$('#widgets_counter').val();
        //console.log(index);
        //Je recupere le prototypes des entrées 
        const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);
        //J'injecte ce code au sein de la div
        $('#annonce_images').append(tmpl);
        $('#widgets_counter').val(index + 1);

        //je gere le button supprimer
        handleDeleteButtons();
    });

    function handleDeleteButtons(){
        $('button[data-action="delete"]').click(function(){
            const target = this.dataset.target;
            //console.log(target);
            $(target).remove();
        });
    }
    function updateCounter(){
        const count = +$('#annonce_images div.form-group').length;

        $('#widgets_counter').val(count);
    }
    updateCounter();
    //des le chargement de la page 
    handleDeleteButtons();