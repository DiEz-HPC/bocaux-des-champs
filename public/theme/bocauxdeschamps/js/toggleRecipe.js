
window.onload = function(){
    var recipeBtn = document.getElementById('recipeBtn');
    var recipeContainer = document.getElementById('recipeContainer');
    var nutritionalBtn = document.getElementById('nutritionalBtn');
    var nutritionalContainer = document.getElementById('nutritionalContainer');

    recipeBtn.addEventListener('click', function(){
        recipeContainer.style.display = 'block';
        nutritionalContainer.style.display = 'none';
        recipeBtn.classList.add('active');
        nutritionalBtn.classList.remove('active');
    });
    nutritionalBtn.addEventListener('click', function(){
        recipeContainer.style.display = 'none';
        nutritionalContainer.style.display = 'block';
        recipeBtn.classList.remove('active');
        nutritionalBtn.classList.add('active');
    });
}
