/*
 * Tree - jQuery Tree Widget
 * @author Valerio Galano <v.galano@daredevel.com>
 * @license MIT
 * @see https://github.com/daredevel/jquery-tree
 * @version 0.1
 */
(function(a, b) {
	a.widget("daredevel.tree", {
		_attachLi : function(d, f, c) {
			var e = f.find("ul:first");
			if (e.length) {
				if ((b == c) || (e.children("li").length < c)) {
					e.append(d)
				} else {
					if (c == 0) {
						c = c + 1
					}
					e.children("li:nth-child(" + c + ")").before(d)
				}
			} else {
				e = a("<ul/>");
				f.append(e.append(d))
			}
		},
		_attachNode : function(e, d, c) {
			if (b == d) {
				var f = this.element;
				this._attachLi(e, f, c);
				this._initializeNode(e)
			} else {
				var f = d;
				this._attachLi(e, f, c);
				f.removeClass("leaf collapsed").addClass("expanded");
				this._initializeNode(e);
				this._initializeNode(f)
			}
		},
		_buildNode : function(e) {
			e = a.extend(true, this.options.defaultNodeAttributes, e);
			var f = a("<span/>", e.span);
			var c = a("<li/>", e.li);
			if (a.inArray("checkbox", this.options.components) > -1) {
				var d = a("<input/>", e.input);
				c.append(d)
			}
			c.append(f);
			return c
		},
		_create : function() {
			var c = this;
			this.options.core = this;
			this.element.addClass("ui-widget ui-widget-content daredevel-tree");
			if (this.options.checkbox) {
				this._createCheckbox()
			}
			if (this.options.collapsible) {
				this._createCollapsible()
			}
			if (this.options.dnd) {
				this._createDnd()
			}
			if (this.options.selectable) {
				this._createSelectable()
			}
			this.element.find("li").each(function() {
				c._initializeNode(a(this))
			});
			if (this.options.nodes != null) {
				a.each(this.options.nodes, function(d, e) {
					c.options.core.addNode(e)
				})
			}
		},
		_destroy : function() {
			a.Widget.prototype.destroy.call(this)
		},
		_detachNode : function(d) {
			var c = this.options.core.parentNode(d);
			var e = c.find("ul:first");
			if (e.children().length == 1) {
				e.detach();
				c.removeClass("collapsed expanded").addClass("leaf")
			} else {
				d.detach()
			}
			this.options.core._initializeNode(c)
		},
		_initializeComponents : function() {
			for (var d in this.options.components) {
				var c = "element.tree" + this.options.components[d] + "(options);";
				run = new Function("options", "element", c);
				run(this.options, this.element)
			}
		},
		_initializeNode : function(c) {
			c.children("span:last").addClass("daredevel-tree-label");
			if (this.options.checkbox) {
				this._initializeCheckboxNode(c)
			}
			if (this.options.collapsible) {
				this._initializeCollapsibleNode(c)
			}
			if (this.options.dnd) {
				this._initializeDndNode(c)
			}
			if (this.options.selectable) {
				this._initializeSelectableNode(c)
			}
		},
		addNode : function(f, e, d) {
			var g = this;
			var c = this._buildNode(f);
			if ((b == e) || 0 == e.length) {
				this._attachNode(a(c), b, d)
			} else {
				this._attachNode(a(c), a(e), d)
			}
			if (b != f.children) {
				a.each(f.children, function(i, h) {
					g.addNode(i, c)
				})
			}
			g._trigger("add", true, c)
		},
		isRoot : function(c) {
			c = a(c);
			var d = c.parentsUntil(".daredevel-tree");
			return 1 == d.length
		},
		moveNode : function(e, d, c) {
			this._detachNode(a(e));
			if ((b == d) || 0 == d.length) {
				this._attachNode(a(e), b, c)
			} else {
				this._attachNode(a(e), a(d), c)
			}
			this._trigger("move", true, a(e))
		},
		parentNode : function(c) {
			return a(c).parents("li:first")
		},
		removeNode : function(c) {
			this._detachNode(a(c));
			this._trigger("remove", true, a(c))
		},
		_allDescendantChecked : function(c) {
			return (c.find("li input:checkbox:not(:checked)").length == 0)
		},
		_checkAncestors : function(c) {
			c.parentsUntil("daredevel-tree").filter("li").find("input:checkbox:first:not(:checked)").prop("checked", true).change()
		},
		_checkDescendants : function(c) {
		//	c.find("li input:checkbox:not(:checked)").prop("checked", true).change()
		},
		_checkOthers : function(c) {
			var d = this;
			c.addClass("exclude");
			c.parents("li").addClass("exclude");
			c.find("li").addClass("exclude");
			a(this.element).find("li").each(function() {
				if (!a(this).hasClass("exclude")) {
					a(this).find("input:checkbox:first:not(:checked)").prop("checked", true).change()
				}
			});
			a(this.element).find("li").removeClass("exclude")
		},
		_createCheckbox : function() {
			var c = this;
			this.element.on("click", "input:checkbox:not(:checked)", function() {
				c.uncheck(c.options.core.parentNode(a(this)))
			});
			this.element.on("click", "input:checkbox:checked", function() {
				c.check(c.options.core.parentNode(a(this)))
			});
			if (this.options.onUncheck.node == "collapse") {
				this.element.on("click", "input:checkbox:not(:checked)", function() {
					c.options.core.collapse(c.options.core.parentNode(a(this)))
				})
			} else {
				if (this.options.onUncheck.node == "expand") {
					this.element.on("click", "input:checkbox:not(:checked)", function() {
						c.options.core.expand(c.options.core.parentNode(a(this)))
					})
				}
			}
			if (this.options.onCheck.node == "collapse") {
				this.element.on("click", "input:checkbox:checked", function() {
					c.options.core.collapse(c.options.core.parentNode(a(this)))
				})
			} else {
				if (this.options.onCheck.node == "expand") {
					this.element.on("click", "input:checkbox:checked", function() {
						c.options.core.expand(c.options.core.parentNode(a(this)))
					})
				}
			}
		},
		_initializeCheckboxNode : function(c) {
		},
		_uncheckAncestors : function(c) {
			c.parentsUntil("daredevel-tree").filter("li").find("input:checkbox:first:checked").prop("checked", false).change()
		},
		_uncheckDescendants : function(c) {
			c.find("li input:checkbox:checked").prop("checked", false).change()
		},
		_uncheckOthers : function(c) {
			var d = this;
			c.addClass("exclude");
			c.parents("li").addClass("exclude");
			c.find("li").addClass("exclude");
			a(this.element).find("li").each(function() {
				if (!a(this).hasClass("exclude")) {
					a(this).find("input:checkbox:first:checked").prop("checked", false).change()
				}
			});
			a(this.element).find("li").removeClass("exclude")
		},
		check : function(c) {
			c = a(c);
			c.find("input:checkbox:first:not(:checked)").prop("checked", true).change();
			if (this.options.onCheck.others == "check") {
				this._checkOthers(c)
			} else {
				if (this.options.onCheck.others == "uncheck") {
					this._uncheckOthers(c)
				}
			}
			if (this.options.onCheck.descendants == "check") {
				this._checkDescendants(c)
			} else {
				if (this.options.onCheck.descendants == "uncheck") {
					this._uncheckDescendants(c)
				}
			}
			if (this.options.onCheck.ancestors == "check") {
				this._checkAncestors(c)
			} else {
				if (this.options.onCheck.ancestors == "uncheck") {
					this._uncheckAncestors(c)
				} else {
					if (this.options.onCheck.ancestors == "checkIfFull") {
						var d = this.options.core.isRoot(c);
						var e = this._allDescendantChecked(this.options.core.parentNode(c));
						if (!d && e) {
							this.check(this.options.core.parentNode(c))
						}
					}
				}
			}
		},
		checkAll : function() {
			a(this.element).find("input:checkbox:not(:checked)").prop("checked", true).change()
		},
		uncheck : function(c) {
			c = a(c);
			c.find("input:checkbox:first:checked").prop("checked", false).change();
			if (this.options.onUncheck.others == "check") {
				this._checkOthers(c)
			} else {
				if (this.options.onUncheck.others == "uncheck") {
					this._uncheckOthers(c)
				}
			}
			if (this.options.onUncheck.descendants == "check") {
				this._checkDescendants(c)
			} else {
				if (this.options.onUncheck.descendants == "uncheck") {
					this._uncheckDescendants(c)
				}
			}
			if (this.options.onUncheck.ancestors == "check") {
				this._checkAncestors(c)
			} else {
				if (this.options.onUncheck.ancestors == "uncheck") {
					this._uncheckAncestors(c)
				}
			}
		},
		uncheckAll : function() {
			a(this.element).find("input:checkbox:checked").prop("checked", false).change()
		},
		_createCollapsible : function() {
			var c = this;
			this.element.on("click", "li span.daredevel-tree-anchor", function() {
				var d = c.options.core.parentNode(a(this));
				if (d.hasClass("collapsed")) {
					c.expand(d)
				} else {
					if (d.hasClass("expanded")) {
						c.collapse(d)
					}
				}
			})
		},
		_initializeCollapsibleNode : function(c) {
			var e = this;
			var d = c.children("span.daredevel-tree-anchor");
			if (d.length < 1) {
				c.prepend(a("<span />", {
					"class" : "daredevel-tree-anchor"
				}))
			}
			if (c.hasClass("leaf")) {
				e._markAsLeaf(c)
			} else {
				if (c.hasClass("collapsed")) {
					e.collapse(c, false, true)
				} else {
					if (c.hasClass("expanded")) {
						e.expand(c, false, true)
					} else {
						if (c.is("li:not(:has(ul))")) {
							e._markAsLeaf(c)
						} else {
							e._markAsExpanded(c)
						}
					}
				}
			}
		},
		_markAsCollapsed : function(c) {
			var d = c.children("span.daredevel-tree-anchor");
			d.removeClass("ui-icon " + this.options.expandUiIcon + " " + this.options.leafUiIcon);
			if (this.options.collapseUiIcon.length > 0) {
				d.addClass("ui-icon " + this.options.collapseUiIcon)
			}
			c.removeClass("leaf").removeClass("expanded").addClass("collapsed")
		},
		_markAsExpanded : function(c) {
			var d = c.children("span.daredevel-tree-anchor");
			d.removeClass("ui-icon " + this.options.collapseUiIcon + " " + this.options.leafUiIcon);
			if (this.options.expandUiIcon.length > 0) {
				d.addClass("ui-icon " + this.options.expandUiIcon)
			}
			c.removeClass("leaf").removeClass("collapsed").addClass("expanded")
		},
		_markAsLeaf : function(c) {
			var d = c.children("span.daredevel-tree-anchor");
			d.removeClass("ui-icon " + this.options.collapseUiIcon + " " + this.options.expandUiIcon);
			if (this.options.leafUiIcon.length > 0) {
				d.addClass("ui-icon " + this.options.leafUiIcon)
			}
			c.removeClass("collapsed").removeClass("expanded").addClass("leaf")
		},
		_unmark : function() {
			li.removeClass("collapsed expanded leaf")
		},
		collapse : function(c, e, f) {
			c = a(c);
			if (f == b) {
				f = false
			}
			if (!f && (c.hasClass("collapsed") || c.hasClass("leaf"))) {
				return
			}
			if (e == b) {
				e = true
			}
			var d = this;
			if (e) {
				c.children("ul").hide(this.options.collapseEffect, {}, this.options.collapseDuration);
				setTimeout(function() {
					d._markAsCollapsed(c, d.options)
				}, d.options.collapseDuration)
			} else {
				c.children("ul").hide();
				d._markAsCollapsed(c, d.options)
			}
			d.options.core._trigger("collapse", true, c)
		},
		collapseAll : function() {
			var c = this;
			a(this.element).find("li.expanded").each(function() {
				c.collapse(a(this))
			})
		},
		expand : function(c, e, f) {
			c = a(c);
			if (f == b) {
				f = false
			}
			if (!f && (c.hasClass("expanded") || c.hasClass("leaf"))) {
				return
			}
			if (e == b) {
				e = true
			}
			var d = this;
			if (e) {
				c.children("ul").show(d.options.expandEffect, {}, d.options.expandDuration);
				setTimeout(function() {
					d._markAsExpanded(c, d.options)
				}, d.options.expandDuration)
			} else {
				c.children("ul").show();
				d._markAsExpanded(c, d.options)
			}
			d.options.core._trigger("expand", true, c)
		},
		expandAll : function() {
			var c = this;
			a(this.element).find("li.collapsed").each(function() {
				c.expand(a(this))
			})
		},
		_createDnd : function() {
			var c = this
		},
		_initializeDndNode : function(c) {
			var d = this;
			var e = a("<span/>", {
				"class" : "prepended",
				html : "<br/>"
			}).droppable({
				hoverClass : "over",
				drop : function(i, j) {
					var h = a(this).closest("li");
					if (d.options.core.isRoot(h)) {
						var g = b;
						var k = d.options.core.element
					} else {
						var g = h.parent().closest("li");
						var k = g;
						if (a(j.draggable.parent("li")).find(g).length) {
							return
						}
					}
					var f = a(a(this).parent("li")).index() + 1;
					d.options.core.moveNode(j.draggable.parent("li"), g, f);
					d._trigger("drop", i, {
						draggable : j.draggable,
						droppable : g
					})
				}
			});
			a(c).find(".daredevel-tree-label:first").after(e);
			a(c).find(".daredevel-tree-label:first").draggable({
				start : function(f, g) {
					a(this).parent("li").find("ul, .prepended").css("visibility", "hidden");
					a(this).parent("li").find(".droppable-label").css("display", "none")
				},
				stop : function(f, g) {
					a(this).parent("li").find("ul").css("visibility", "visible");
					a(this).parent("li").find(".prepended").css("visibility", "");
					a(this).parent("li").find(".droppable-label").css("display", "inherit")
				},
				revert : true,
				revertDuration : 0
			});
			var e = a("<span/>", {
				"class" : "droppable-label",
				html : "<br/>"
			}).droppable({
				drop : function(g, h) {
					var f = a(this).closest("li");
					if (a(h.draggable.parent("li")).find(f).length) {
						return
					}
					d.options.core.moveNode(h.draggable.parent("li"), f, 1);
					d._trigger("drop", g, {
						draggable : h.draggable,
						droppable : f
					})
				},
				over : function(f, g) {
					a(this).parent("li").find(".daredevel-tree-label:first").addClass("ui-state-hover")
				},
				out : function(f, g) {
					a(this).parent("li").find(".daredevel-tree-label:first").removeClass("ui-state-hover")
				}
			});
			a(c).find(".daredevel-tree-label:first").after(e)
		},
		_createSelectable : function() {
			var d = this;
			var c = ".daredevel-tree-label:not(." + this.options.selectUiClass + ")";
			this.element.on("click", c, function() {
				d.select(a(this).parent("li"))
			})
		},
		_deselect : function(c) {
			c.find("span.daredevel-tree-label:first").removeClass(this.options.selectUiClass);
			this._trigger("deselect", true, c)
		},
		_destroySelectable : function() {
		},
		_initializeSelectableNode : function(c) {
		},
		_select : function(c) {
			c.find("span.daredevel-tree-label:first").addClass(this.options.selectUiClass);
			this._trigger("select", true, c)
		},
		deselect : function() {
			var c = this;
			this.element.find(".daredevel-tree-label." + this.options.selectUiClass).each(function() {
				c._deselect(a(this).parent("li"))
			})
		},
		select : function(c) {
			c = a(c);
			this.deselect();
			this._select(c)
		},
		selected : function() {
			var c = this.element.find(".daredevel-tree-label." + this.options.selectUiClass);
			return a(c).parent()
		},
		options : {
			defaultNodeAttributes : {
				span : {
					html : "new node"
				},
				li : {
					"class" : "leaf"
				},
				input : {
					type : "checkbox"
				}
			},
			nodes : null,
			checkbox : true,
			onCheck : {
				ancestors : "check",
				descendants : "check",
				node : "",
				others : ""
			},
			onUncheck : {
				ancestors : "",
				descendants : "uncheck",
				node : "",
				others : ""
			},
			collapsible : true,
			collapseDuration : 500,
			collapseEffect : "blind",
			collapseUiIcon : "ui-icon-triangle-1-e",
			expandDuration : 500,
			expandEffect : "blind",
			expandUiIcon : "ui-icon-triangle-1-se",
			leafUiIcon : "",
			dnd : true,
			drop : function(d, c) {
			},
			selectable : true,
			deselect : function(d, c) {
			},
			selectUiClass : "ui-state-active",
			select : function(d, c) {
			}
		}
	});
	a.ui.draggable.prototype._getRelativeOffset = function() {
		if (this.cssPosition == "relative") {
			var c = this.element.position();
			return {
				top : c.top - (parseInt(this.helper.css("top"), 10) || 0),
				left : c.left - (parseInt(this.helper.css("left"), 10) || 0)
			}
		} else {
			return {
				top : 0,
				left : 0
			}
		}
	}
})(jQuery); 