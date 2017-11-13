(function($) {
	acf.fields.sections = acf.field.extend({
		type: 'sections',

		actions: {
			'ready': 'initialize',
			'append': 'initialize',

			'sortstop': 'refresh'
		},

		events: {
			'click .acf-section-add': 'add',

			'click .acf-section-remove': 'remove',
			'click .acf-section-appearance': 'appearance',

			'click .acf-section-handle': 'toggle',

			'blur .acf-fc-popup a': 'close_popup',
			'blur .acf-fc-popup .focus': 'close_popup'
		},

		focus: function() {
			if(! this.$clones) {
				this.$clones = $('#acf-section-clones');
				this.$clones.find('[name]').attr('disabled', 'disabled');
			}

			this.$editor = this.$field.find('.acf-section-editor').first();
			this.$values = this.$editor.children('.acf-section-values');
			this.$empty = this.$editor.children('.acf-section-empty');

			if(! this.$field.data('created')) {
				var self = this;
				this.$values.sortable({
					item: '> .acf-section',
					handle: '> .acf-section-handle',
					scroll: true,

					tolerance: 'pointer',

					placeholder: 'acf-section-placeholder',
					forcePlaceholderSize: true,

					connectWith: '.acf-section-values',
					start: function(e, ui) { acf.do_action('sortstart', ui.item, ui.placeholder); self.sortstart(); },
					stop: function(e, ui) { acf.do_action('sortstop', ui.item, ui.placeholder); self.sortstop(); },
					update: function(e, ui) {
						if(ui.sender) {
							var current_name = ui.sender.closest('.acf-section-editor').attr('data-current-name');
							var new_name = ui.item.closest('.acf-section-editor').attr('data-current-name');
							self.switch_field_name(ui.item, current_name, new_name);
						}
					}
				});

				this.refresh();

				this.$field.data('created', true);
			}
		},

		initialize: function() {
		},

		add: function(e) {
			e.preventDefault();
			e.stopImmediatePropagation();

			var self = this;
			this.open_popup(e.$el, '#acf-sections-menu', function(action) {
				self.add_section(action);
			});
		},

		add_section: function(name) {
			var new_id = this.$editor.attr('data-current-name') + '[' + acf.get_uniqid() + ']';
			var html = this.$clones.children('[data-id=' + name + ']').outerHTML();

			var $html = $(html);
			//$html.find('.acf-section-editor').attr('data-current-name', new_id);
			$html.find('[name]').removeAttr('disabled');
			$html.removeClass('acf-clone');
			this.switch_field_name($html, 'acfcloneindex', new_id);

			this.$values.append($html);

			acf.do_action('append', $html);

			this.refresh();
		},

		remove: function(e) {
			console.log('remove');
			e.preventDefault();
			e.stopImmediatePropagation();

			var section = e.$el.closest('.acf-section');
			var self = this;
			acf.remove_el(section, function() {
				self.refresh();
			});
		},

		switch_field_name: function(el, current, new_name) {
			var old_id = current.replace(/[\[\]]/g, '');
			var new_id = new_name.replace(/[\[\]]/g, '');
			console.log('switch name', current, 'to', new_name);
			el.find('[id], [name], [data-current-name]').each(function() {
				var $this = $(this);
				if($this.attr('id')) {
					console.log('replacing id', $this.attr('id'), this);
					$this.attr('id', $this.attr('id').replace(old_id, new_id));
				}

				if($this.attr('name')) {
					console.log('replacing this', $this.attr('name'), this);
					$this.attr('name', $this.attr('name').replace(current, new_name));
				}

				if($this.attr('data-current-name')) {
					console.log('replacing data-name', $this.attr('data-current-name'), this);
					$this.attr('data-current-name', $this.attr('data-current-name').replace(current, new_name));
				}
			});
		},

		toggle: function(e) {
			var section = e.$el.closest('.acf-section');
			if(section.attr('data-toggle') == 'closed') {
				section.attr('data-toggle', 'open');
				section.find('> .acf-section-content').show();
			} else {
				section.attr('data-toggle', 'closed');
				section.find('> .acf-section-content').hide();
			}
		},

		open_popup: function(button, popup, handler, selectedHandler) {
			popup = $(popup);
			button = $(button);

			var self = this;
			var field = this.$field;

			popup.off('.handler');
			popup.on('click.handler', 'a', function(e) {
				e.preventDefault();

				self.doFocus(field);

				var action = $(this).attr('data-action');
				var allSelected = [ action ];
				var group = $(this).closest('[data-group]').attr('data-group');
				popup.find('[data-group]').each(function() {
					var $g = $(this);
					if($g.attr('data-group') === group) return;

					$g.find('a.selected').each(function() {
						allSelected.push($(this).attr('data-action'));
					});
				});

				console.log(allSelected);

				handler(action, group, allSelected);
				popup.hide();
			});

			if(selectedHandler) {
				popup.find('[data-group]').each(function() {
					var $g = $(this);
					var links = $g.find('a');
					var actions = [];
					links.each(function() {
						var action = $(this).attr('data-action');
						if(action !== '') {
							actions.push(action);
						}
					});

					links.each(function() {
						var $this = $(this);
						if(selectedHandler($this, actions)) {
							$this.addClass('selected');
						} else {
							$this.removeClass('selected');
						}
					});
				});
			}

			popup.show();
			popup.position({
				my: 'center bottom-15',
				at: 'center top',
				of: button
			});

			popup.children('.focus').trigger('focus');
		},

		close_popup: function(e) {
			var $popup = e.$el.closest('.acf-fc-popup');
			this._popupTimer = setTimeout(function() {
				var parentPopup = $(document.activeElement).closest('.acf-fc-popup')[0];
				if(parentPopup != $popup[0]) {
					$popup.hide();
				}
			}, 200);
		},

		appearance: function(e) {
			e.preventDefault();

			var section = e.$el.closest('.acf-section');
			var id = section.attr('data-id');

			var input = section.find('> [data-name=acf_section_style_class]');
			var val = input.val();
			var selected = val.split(' ');
			this.open_popup(e.$el, '#acf-section-style-' + id, function(action, g, newSelected) {
				input.val(newSelected.join(' '));
			}, function(el, actions) {
				var current = el.attr('data-action');
				if(current === '') {
					// The default value
					for(var i=0; i<selected.length; i++) {
						if(actions.indexOf(selected[i]) >= 0) return false;
					}

					return true;
				}

				return selected.indexOf(current) >= 0;
			});
		},

		refresh: function() {
			if(this.$values.children('.acf-section').length) {
				this.$empty.hide();
			} else {
				this.$empty.show();
			}
		},

		sortstart: function() {
			$('.acf-field.field_type-sections').addClass('acf-sections-sorting');
		},

		sortstop: function() {
			var self = this;
			$('.acf-field.field_type-sections').removeClass('acf-sections-sorting').each(function() {
				self.doFocus($(this));
				self.refresh();
			});
		}
	});
})(jQuery);
