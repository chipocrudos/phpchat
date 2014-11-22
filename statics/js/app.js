var userModel = Backbone.Model.extend({
	urlRoot: 'api.php/user/',
});

var userCollection = Backbone.Collection.extend({
	url: 'api.php/user/',
	model: userModel,
});

var lineModel = Backbone.Model.extend({
	urlRoot: 'api.php/line/'
});

var lineCollection = Backbone.Collection.extend({
	//url: 'api.php/line/',
	model: lineModel,
	initialize: function(option){
		this.li = false;
		if (option){
			this.li = option.li;	
		}		
	},
	url: function(){
		if (this.li){
			// return 'api.php/line/' + encodeURIComponent(this.li);
			return 'api.php/line/' + this.li;
		} else {
			return 'api.php/line/';	
		}
	}
	
});

var ListView = Backbone.Marionette.CollectionView.extend({
  initialize: function(){
  	this.$el.html('');
  }
});

var liListView = Backbone.Marionette.CollectionView.extend();

var liUserView = Backbone.Marionette.ItemView.extend({
  tagName: 'li',
  className: 'list-group-item',
  template: _.template('<img alt="Brand" height="25" src="<%= urlimg %>"> <%= nick %>')
});

var liLineView = Backbone.Marionette.ItemView.extend({
  tagName: 'li',
  className: 'list-group-item',
  template: _.template('<img alt="Brand" height="25" src="<%= urlimg %>"> <%= nick %> <%= ts %>: <%= msg %>'),
});

var MainView = Backbone.View.extend({
	el: 'body',
	usercollection: new userCollection(),
	events: {
		'click .btn-login': 'login',
		'click #btn-login': 'logIn',
		'click .btn-logout': 'logOut',
		'click #btn-snd': 'sendMsg',
		'keypress': 'sendKey',
	},
	initialize: function(){
		this.recoverState();
		var self = this;
		setInterval(function(){
			self.userBox();
		}, 5000);

	},
	recoverState: function(){
		if (localStorage.id) {
			console.log('status login');
			console.log(localStorage);
			this.$('.btn-login').addClass('hide');
        	this.$('.btn-logout').removeClass('hide');
    		this.$('.welcome-box').addClass('hide');
    		this.$('.chat-box').removeClass('hide');
    		this.model = new userModel({id:localStorage.id});
    		this.model.fetch();
			this.sendWelcome();
			this.userBox();
		}else{
			console.log('status no login');
			this.$('.btn-login').removeClass('hide');
    		this.$('.btn-logout').addClass('hide');
    		this.$('.welcome-box').removeClass('hide');
    		this.$('.chat-box').addClass('hide');
		}
	},
	login: function(){
		console.log('login');
		this.$('#login-modal').modal('show');
	},
	logIn: function(){
		console.log('logIn');
		var self = this;
		var nick = this.$("#nick").val();
        var urlimg = this.$("#urlimg").val();
        this.model = new userModel();
        
        if (!urlimg){
        	urlimg = 'http://us.cdn1.123rf.com/168nwm/glopphy/glopphy1307/glopphy130700014/20748751-gato-perro-y-conejo-cabezas-siluetas.jpg';
        }

        this.model.save({nick:nick, urlimg:urlimg}, {
        	wait: true,
    		success: function(model, request, options){
        		console.log('success guardar');
        		self.$('#login-modal').modal('hide');
        		self.$('.btn-login').addClass('hide');
        		self.$('.btn-logout').removeClass('hide');
        		self.$('.welcome-box').addClass('hide');
        		self.$('.chat-box').removeClass('hide');
        		localStorage.setItem('id', model.get('id'));
				localStorage.setItem('nick', model.get('nick'));
				localStorage.setItem('urlimg', model.get('urlimg'));
				console.log(localStorage);
				self.sendWelcome();
				self.userBox();
        	},
        	error: function(model, xhr, options) {
        		console.log('error al guardar');
        		console.log(xhr.responseText);
        	}
    	});
	},
	logOut: function(){
		this.sendBye();
		this.model.destroy();
		this.$('.btn-login').removeClass('hide');
    	this.$('.btn-logout').addClass('hide');
		this.$('.welcome-box').removeClass('hide');
		this.$('.chat-box').addClass('hide');
		localStorage.removeItem('id');
		localStorage.removeItem('nick');
		localStorage.removeItem('urlimg');
	},
	userBox: function(){
		if (localStorage.id) {
			var self = this;
			this.usercollection.fetch({
				wait: true,
				success: function(collection, request, options){
					new ListView({
					  collection: collection,
					  el: '#user-box ul',
					  childView: liUserView
					}).render();
					if(!localStorage.li || localStorage.li == 'undefined'){
						self.sendWelcome();
					};
					
				}
			});
			this.getMsg();			
		}
	},
	sendWelcome: function() {
		var linemodel = new lineModel();
		// var self = this;
        linemodel.save({nick:localStorage.nick, urlimg:localStorage.urlimg, msg:'A entrado a la sala'}, {
        	wait: true,
    		success: function(model, request, options){
        		console.log('success guardar bienvenida');
        		localStorage.setItem('li', model.get('id'));
        		// self.getMsg();
        	},
        	error: function(model, xhr, options) {
        		console.log('error al guardar');
        		console.log(xhr.responseText);
        	}
    	});	
	},
	sendBye: function() {
		if (localStorage.id) {
			var linemodel = new lineModel();
	        linemodel.save({nick:localStorage.nick, urlimg:localStorage.urlimg, msg:'A dejado la sala'}, {
	        	wait: true,
	    		success: function(model, request, options){
	        		console.log('success guardar salida');
	        	},
	        	error: function(model, xhr, options) {
	        		console.log('error al guardar');
	        		console.log(xhr.responseText);
	        	}
	    	});	
	    }
	},
	sendMsg: function() {
		var msg = this.$("#msg").val();
		this.$("#msg").val('');
		var linemodel = new lineModel();
		var self = this;
		if (msg){
			linemodel.save({nick:localStorage.nick, urlimg:localStorage.urlimg, msg:msg}, {
	        	wait: true,
	    		success: function(model, request, options){
	        		console.log('success guardar');
	        		localStorage.setItem('li', model.get('id'));
	        		self.getMsg();
	        	},
	        	error: function(model, xhr, options) {
	        		console.log('error al guardar');
	        		console.log(xhr.responseText);
	        	}
	    	});	
		}
        
	},
	sendKey: function(e) {
		if (event.keyCode == 13 && event.type == 'keypress'){
			e.preventDefault();
			this.sendMsg()
		};
	},
	getMsg: function(){
			if (localStorage.id) {
				// console.log('lines');
				// console.log(localStorage.li);
				this.linecollection = new lineCollection({'li':localStorage.li});
				this.linecollection.fetch({
				wait: true,
				success: function(collection, request, options){
					new liListView({
					  collection: collection,
					  el: '#chat-box ul',
					  childView: liLineView,
					}).render();
					$('#chat-box').scrollTop( $('#chat-box').height() );
					if (collection.length){
						var id = collection.last().get('id');
						localStorage.setItem('li', Number(id)+1);	
					}
					
				}
			});

		}
	}

});


var mainView = new MainView();