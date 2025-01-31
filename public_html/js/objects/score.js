(function(namespace) {
	var SCORE_FACTOR = 0.1;

	function formatOffset(offset) {
		// TODO pad with zeroes
		return Math.floor(offset * SCORE_FACTOR);
	}

	function ScoreBoard(options) {
		this.scale = options.scale;
		this.x = options.left || window.innerWidth / 2;
		this.y = options.bottom || 40;
		this.colour = options.colour || "blue";
	}

	ScoreBoard.prototype = Object.create(GameObject.prototype);
	ScoreBoard.prototype.constructor = ScoreBoard;

	ScoreBoard.prototype.draw = function(context, offset) {
		context.fillStyle = this.colour;
		context.font = "48px Courier";
		context.textAlign = "center"; 
		context.fillText(formatOffset(offset), this.x, this.y);
	};

	namespace.ScoreBoard = ScoreBoard;
})(window);