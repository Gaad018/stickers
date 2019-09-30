(function() {


				//Подгрузка контента из базы для пользователя 

				
				let zIndex = 0;
				let zIndexDrag = 0;
                if (window.id == NaN ||  window.id == -1) {
                    id = 0;
                }


				//Создание textarea
				document.addEventListener('dblclick', function(event) {

					let textarea = document.createElement('textarea');
					//Атрибуты
					textarea.className = 'sticker';
					textarea.id = ++id;
					textarea.draggable = true;
					textarea.value = 'Текст...';

					//css свойства
					textarea.style.zIndex = ++zIndex;
					textarea.style.left = event.pageX + 'px';
					textarea.style.top = event.pageY + 'px';
					textarea.style.height = 150 + 'px';
					textarea.style.width = 200 + 'px';

                    document.body.appendChild(textarea);
                    
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
                            console.log(this.value);
                            console.log(oldText);
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
                    console.log(change);
                        conditious = 'deleteObject=' + change;
                    break;
                }

                searchParams = new URLSearchParams( conditious );
                let promise = fetch('ajax.php', {
                    method: 'POST',
                    body: searchParams
                })
            }                                
               
    }()); 
    
