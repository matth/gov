/**
 * Make autocomplete dropdown thing for search
 * @author Matt Haynes <matt@matthaynes.net>
 */
glow.ready(function() {
	
	var lastInputValue,
		selectedItem,
		populateTimeout,
		hasMatches = false,
		searchField = glow.dom.get('#searchField'),
		resultsHtml = glow.dom.create('<div id="autoCompleteResults"></div>').appendTo('#search_form');
		
	function formSubmit(event) {
		alert('ok');
		searchField.val(selectedItem.text());
		resultsHtml.hide();
		searchField[0].blur();		
		return false;
	}		

	function inputPress(event) {
		
		if (hasMatches) {
		
			resultsHtml.show();
			
			if (event.key == "DOWN") {
				if (selectedItem.next().length > 0) {
					selectedItem.removeClass('selected');
					selectedItem = selectedItem.next();
					selectedItem.addClass('selected');
				}
				return false;
			} else if (event.key == "UP") {
				if (selectedItem.prev().length > 0) {
					selectedItem.removeClass('selected');
					selectedItem = selectedItem.prev();
					selectedItem.addClass('selected');
				}
				return false;
			} else if (event.key == "RIGHT") {
				searchField.val(selectedItem.text());
				populate();
				return false;
			} 
		}
		
		return true;
	
	}
	
	function inputChange() {
		
		var searchValue = searchField.val().toLowerCase();
		
		if (searchValue == lastInputValue) {
			return;
		}
		
		clearTimeout(populateTimeout);
		populateTimeout = setTimeout(populate, 300);
		
	}
	
	function populate() {
									
			var	searchValue = searchField.val().toLowerCase(),
				searchKey   = searchValue.substring(0,1),
				searchArray = mpData[searchKey];
				
			hasMatches = false;	
			selectedItem = null;
			lastInputValue = searchValue;
			
			resultsHtml.get('*').remove();
				
			if (searchArray) {

				for (var i=0, len = searchArray.length; i < len; i++) {
					
					var constituency = searchArray[i][0]; 
				
					if (searchValue == constituency.toLowerCase().substring(0, searchValue.length)) {
						
						var result = glow.dom.create('<div class="result">' + searchArray[i][0] + '</div>');
						if (hasMatches == false) {
							hasMatches = true;
							selectedItem = result;
							result.addClass('selected');
						}
						result.appendTo(resultsHtml);
					}
				 
				}
			}
	}
	
	glow.events.addListener(
  		searchField,
  		'keydown',
  		inputChange	
    );
    
    glow.events.addListener(searchField, "keyup", inputPress);
    glow.events.addListener('#search_form form', "submit", formSubmit);
    glow.events.addListener(searchField, "blur", function() {resultsHtml.hide()});
    
});