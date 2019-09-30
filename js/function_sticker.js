(function() {


	//Подгрузка контента из базы для пользователя 
	let zIndex = 0;
	let zIndexDrag = 0;
    if (window.id == NaN ||  window.id == -1) {
        id = 0;
    }

    let arrays = new Array();
    arrays = window.array;
    if (arrays !== null) {
        for(array of arrays) {

            addElementInDocument(
                array.type,
                array.class,
                array.id,
                true,
                array.text,
                array.style
                )
        } 
    }


	//Создание textarea
	document.addEventListener('dblclick', function(event) {
        let style = 'z-index:' + ++zIndex + 
        '; left:' +  event.pageX + 'px' + 
        '; top:' + event.pageY + 'px' +
        '; height:' +  150 + 'px' +
        ';width:' + 200 + 'px';

        let textarea =  addElementInDocument(
            'textarea', 
            'sticker',  
            ++id, 
            true, 
            'Текст...',  
            style
            )

            save('update', textarea.outerHTML, 'creat', 'Текст...');

            let stickers = document.querySelectorAll('.sticker');
            for (sticker of stickers) {
                let oldWidth = 200;
                let oldHeight = 150;
                let oldText = '';
                zIndexDrag = zIndex;


                //Изменение размера оббъекта
                sticker.addEventListener('mouseup', function(event)  {
                    if (oldWidth !== this.style.width || oldHeight !== this.style.height) {
                        if (oldWidth != parseInt(this.style.width)) {
                            save('update', this.outerHTML, 'updateWidth');
                        }
                        if (oldHeight != parseInt(this.style.height)) {
                            save('update', this.outerHTML, 'updateHeight');
                        }
                        oldWidth = this.style.width;
                        oldHeight = this.style.height;
                    }
                    event.preventDefault();
                });

                //Изменение текста внутри объекта
                sticker.addEventListener('change', function(event) {
                    if (oldText !== this.value) {
                        save('update', this.outerHTML, 'updateText', this.value);
                    }
                    if (this.value == '') {
                        save('update', this.outerHTML, 'updateText', ' ');
                    }
                    oldText = this.value;
                    event.preventDefault();
                });

                //Изменение индекса объекта при фокусе
                let oldIndex = sticker.style.zIndex;
                sticker.addEventListener('click', function(event) {
                    this.style.zIndex = ++zIndexDrag;
                    event.preventDefault();
                })	
                sticker.addEventListener('blur', function(event) {
                    this.style.zIndex = oldIndex;
                })

                event.preventDefault();
                }
            });  
            
        //Перемещение объекта 
        let textareaMany = document.getElementsByTagName('textarea');
        for (value of textareaMany) {
            value.addEventListener('dragstart', function(event) {
            window.correctionX = parseInt(event.pageX) - parseInt(this.style.left);
            window.correctionY = parseInt(event.pageY) - parseInt(this.style.top);
            ++zIndexDrag;
            });

            value.addEventListener('dragend', function(event) {
                this.style.left = event.pageX -  window.correctionX + 'px';
                this.style.top = event.pageY -  window.correctionY + 'px';
                this.style.zIndex = zIndexDrag;
                save('update', this.outerHTML, 'Перемещене');
            });

        }

        //Удаление textarea
        document.addEventListener('mousedown', function(event) {
            if (event.which == 2) {
                let sticker_delete = document.getElementById(event.target.id);
                sticker_delete.outerHTML = '';
                save('deleteObject', sticker_delete.id);
                event.preventDefault();
            }
        });
        
        function save(wathChange, change, changes, valueText) {
            let conditious = '';
            switch (wathChange) {
                case 'update':
                    if (valueText == '') {
                        valueText = 'text';
                    }
                    conditious = 'object=' + change + '&changes=' + changes + '&id=' + window.idLogin + '&text=' + valueText;
                break;

                case 'deleteObject':
                    conditious = 'deleteObject=' + change;
                break;
            }

            searchParams = new URLSearchParams( conditious );
            let promise = fetch('ajax.php', {
                method: 'POST',
                body: searchParams
            })
        }                                
            

        function addElementInDocument(name_element, className, id, draggable, value, style) {
            let elem = document.createElement(name_element);
            //Атрибуты
            elem.className = className;
            elem.id = id;
            elem.draggable = draggable;
            elem.value = value;

            //css свойства
            elem.style = style;

            document.body.appendChild(elem);
            return elem;
        }
    }()); 
    
