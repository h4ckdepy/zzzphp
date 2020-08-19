$(document).ready(function(){
	
	// The select element to be replaced:
	var select = $('.makeMeFancy');

	var selectBoxContainer = $('<div>',{
		class		: 'tzSelect',
		html		: '<div class="selectBox"></div>'
	});

	var dropDown = $('<ul>',{class:'dropDown'});
	var selectBox = selectBoxContainer.find('.selectBox');
	//alert(selectBox.text())
	// Looping though the options of the original select element
	
	select.find('option').each(function(i){
		var option = $(this);	
		if(i==select.get(0).selectedIndex){
		
			selectBox.html(option.text());
		}
		
		// As of jQuery 1.4.3 we can access HTML5 
		// data attributes with the data() method.
		
		if(option.data('skip')){
			return true;
		}
		
		// Creating a dropdown item according to the
		// data-icon and data-html-text HTML5 attributes:
		
		var li = $('<li>',{
			html:	'<img src="'+option.data('icon')+'" /><span>'+
					option.data('html-text')+'</span>'
		});
				
		li.click(function(){
			
			selectBox.html(option.text());
			dropDown.trigger('hide');
			
			// When a click occurs, we are also reflecting
			// the change on the original select element:
			select.val(option.val());
			getoption(option.val())
			//alert($("#qqkf").val())
			return false;
		});
		
		dropDown.append(li);
	});
	
	selectBoxContainer.append(dropDown.hide());
	select.hide().after(selectBoxContainer);
	
	// Binding custom show and hide events on the dropDown:
	
	dropDown.on('show',function(){
		
		if(dropDown.is(':animated')){
			return false;
		}
		
		selectBox.addClass('expanded');
		dropDown.slideDown();
		
	}).on('hide',function(){
		
		if(dropDown.is(':animated')){
			return false;
		}		
		selectBox.removeClass('expanded');
		dropDown.slideUp();
		
	}).on('toggle',function(){
		if(selectBox.hasClass('expanded')){
			dropDown.trigger('hide');
		}
		else dropDown.trigger('show');
	});
	
	selectBox.click(function(){
		dropDown.trigger('toggle');
		return false;
	});

	// If we click anywhere on the page, while the
	// dropdown is shown, it is going to be hidden:
	
	$(document).click(function(){
		dropDown.trigger('hide');
	});
});