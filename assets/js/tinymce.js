(function() {
  return tinymce.PluginManager.add("trendmag_shortcodes", function(editor) {
    var grid;
    grid = new Array(12);
    grid[0] = "[trendmag_col size=12]TEXT[/trendmag_col]<br/>";
    grid[1] = "[trendmag_col size=6]TEXT[/trendmag_col]<br/>";
    grid[1] += "[trendmag_col size=6]TEXT[/trendmag_col]<br/>";
    grid[2] = "[trendmag_col size=4]TEXT[/trendmag_col]<br/>";
    grid[2] += "[trendmag_col size=4]TEXT[/trendmag_col]<br/>";
    grid[2] += "[trendmag_col size=4]TEXT[/trendmag_col]<br/>";
    grid[3] = "[trendmag_col size=4]TEXT[/trendmag_col]<br/>";
    grid[3] += "[trendmag_col size=8]TEXT[/trendmag_col]<br/>";
    grid[4] = "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[4] += "[trendmag_col size=6]TEXT[/trendmag_col]<br/>";
    grid[4] += "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[5] = "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[5] += "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[5] += "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[5] += "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[6] = "[trendmag_col size=3]TEXT[/trendmag_col]<br/>";
    grid[6] += "[trendmag_col size=9]TEXT[/trendmag_col]<br/>";
    grid[7] = "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[7] += "[trendmag_col size=8]TEXT[/trendmag_col]<br/>";
    grid[7] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[8] = "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[8] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[8] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[8] += "[trendmag_col size=6]TEXT[/trendmag_col]<br/>";
    grid[9] = "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[9] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[9] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[9] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[9] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[9] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    grid[10] = "[trendmag_col size=8]TEXT[/trendmag_col]<br/>";
    grid[10] += "[trendmag_col size=4]TEXT[/trendmag_col]<br/>";
    grid[11] = "[trendmag_col size=10]TEXT[/trendmag_col]<br/>";
    grid[11] += "[trendmag_col size=2]TEXT[/trendmag_col]<br/>";
    return editor.addButton("trendmag_shortcodes", {
      type: "splitbutton",
      title: trendmag_toolkit.i18n.shortcodes,
      icon: "trendmag_shortcodes",
      menu: [
        {
          text: trendmag_toolkit.i18n.grid,
          menu: [
            {
              text: "1/1",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[0] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/2 - 1/2",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[1] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/3 - 1/3 - 1/3",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[2] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/3 - 2/3",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[3] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/4 - 1/2 - 1/4",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[4] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/4 - 1/4 - 1/4 - 1/4",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[5] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/4 - 3/4",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[6] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/6 - 4/6 - 1/6",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[7] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/6 - 1/6 - 1/6 - 1/2",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[8] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[9] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "2/3 - 1/3",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[10] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: "5/6 - 1/6",
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_row]<br/>" + grid[11] + "[/trendmag_row]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }
          ]
        }, {
          text: trendmag_toolkit.i18n.container,
          menu: [
            {
              text: trendmag_toolkit.i18n.tabs,
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_tabs]<br/>";
                shortcode += "[trendmag_tab title=\"Tab title 1\"]Tab content 1[/trendmag_tab]<br/>";
                shortcode += "[trendmag_tab title=\"Tab title 2\"]Tab content 2[/trendmag_tab]<br/>";
                shortcode += "[trendmag_tab title=\"Tab title 3\"]Tab content 3[/trendmag_tab]<br/>";
                shortcode += "[/trendmag_tabs]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: trendmag_toolkit.i18n.accordion,
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_accordions]<br/>";
                shortcode += "[trendmag_accordion title=\"Accordion title 1\"]Accordion content 1[/trendmag_accordion]<br/>";
                shortcode += "[trendmag_accordion title=\"Accordion title 2\"]Accordion content 2[/trendmag_accordion]<br/>";
                shortcode += "[trendmag_accordion title=\"Accordion title 3\"]Accordion content 3[/trendmag_accordion]<br/>";
                shortcode += "[/trendmag_accordions]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: trendmag_toolkit.i18n.toggle,
              onclick: function() {
                var shortcode;
                shortcode = "[trendmag_toggles]<br/>";
                shortcode += "[trendmag_toggle title=\"Toggle title 1\"]Toggle content 1[/trendmag_toggle]<br/>";
                shortcode += "[trendmag_toggle title=\"Toggle title 2\"]Toggle content 2[/trendmag_toggle]<br/>";
                shortcode += "[trendmag_toggle title=\"Toggle title 3\"]Toggle content 3[/trendmag_toggle]<br/>";
                shortcode += "[/trendmag_toggles]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }
          ]
        }, {
          text: trendmag_toolkit.i18n.dropcap,
          icon: "dropcap",
          menu: [
            {
              text: trendmag_toolkit.i18n.transparent,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_dropcap class=\"kopa-dropcap style-1\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_dropcap]");
              }
            }, {
              text: trendmag_toolkit.i18n.circle,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_dropcap class=\"kopa-dropcap style-2\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_dropcap]");
              }
            }, {
              text: trendmag_toolkit.i18n.rectangle,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_dropcap class=\"kopa-dropcap style-3\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_dropcap]");
              }
            }
          ]
        }, {
          text: trendmag_toolkit.i18n.alert,
          menu: [
            {
              text: trendmag_toolkit.i18n.info,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_alert class=\"alert alert-info alert-dismissable fade in\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_alert]");
              }
            }, {
              text: trendmag_toolkit.i18n.success,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_alert class=\"alert alert-success alert-dismissable fade in\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_alert]");
              }
            }, {
              text: trendmag_toolkit.i18n.warning,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_alert class=\"alert alert-warning alert-dismissable fade in\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_alert]");
              }
            }, {
              text: trendmag_toolkit.i18n.danger,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_alert class=\"alert alert-danger alert-dismissable fade in\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_alert]");
              }
            }, {
                  text:trendmag_toolkit.i18n.notice,
                  onclick: function() {
                      return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_alert class=\"alert alert-notice alert-dismissable fade in\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_alert]");
                  }
              }
          ]
        },
          {
          text: trendmag_toolkit.i18n.button,
          menu: [
            {
              text: trendmag_toolkit.i18n.white,
              menu: [
                {
                  text: trendmag_toolkit.i18n.small,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_button class=\"btn btn-default btn-sm\" link=\"#\" target=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_button]");
                  }
                }, {
                  text: trendmag_toolkit.i18n.medium,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_button class=\"btn btn-default btn\" link=\"#\" target=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_button]");
                  }
                }, {
                  text: trendmag_toolkit.i18n.large,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_button class=\"btn btn-default btn-lg\" link=\"#\" target=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_button]");
                  }
                }
              ]
            }, {
              text: trendmag_toolkit.i18n.black,
              menu: [
                {
                  text: trendmag_toolkit.i18n.small,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_button class=\"btn btn-black btn-sm\" link=\"#\" target=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_button]");
                  }
                }, {
                  text: trendmag_toolkit.i18n.medium,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_button class=\"btn btn-black btn\" link=\"#\" target=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_button]");
                  }
                }, {
                  text: trendmag_toolkit.i18n.large,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[trendmag_button class=\"btn btn-black btn-lg\" link=\"#\" target=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/trendmag_button]");
                  }
                }
              ]
            }
          ]
        },{
          text: trendmag_toolkit.i18n.caption,
          onclick: function() {
            var shortcode;
            shortcode = "[trendmag_caption]Caption[/trendmag_caption]<br/>";
            return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
          }
        }
      ]
    });
  });
})();
