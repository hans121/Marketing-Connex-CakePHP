{
  "page": {
    "title": "Template Base",
    "description": "Test template for BEE",
    "template": {
      "name": "template-base",
      "type": "basic",
      "version": "0.0.1"
    },
    "body": {
      "type": "mailup-bee-page-proprerties",
      "container": {
        "style": {
          "background-color": "red"
        }
      },
      "content": {
        "style": {
          "font-family": "Arial, 'Helvetica Neue', Helvetica, sans-serif",
          "color": "#000000"
        },
        "computedStyle": {
          "linkColor": "#0000FF",
          "messageBackgroundColor": "transparent",
          "messageWidth": "600px"
        }
      }
    },
    "rows": [{
      "type": "two-columns-image-text",
      "container": {
        "style": {
          "background-color": "#32373A"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#333",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 4,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/logo-bee.png",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "left",
              "width": 65
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "15px",
          "padding-right": "10px",
          "padding-bottom": "15px",
          "padding-left": "10px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }, {
        "grid-columns": 8,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: right; line-height: 21px;\" data-mce-style=\"text-align: right;\"><span style=\"font-size: 16px; font-family: inherit; line-height: 21px;\" data-mce-style=\"font-size: 16px; font-family: inherit; line-height: 21px;\">Bee 2.0 is <span style=\"line-height: 21px;\" data-mce-style=\"line-height: 21px;\">now</span> available&nbsp;</span></div>",
              "style": {
                "color": "#989898",
                "line-height": "160%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "20px",
              "padding-right": "10px",
              "padding-bottom": "15px",
              "padding-left": "10px"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "5px",
          "padding-right": "0px",
          "padding-bottom": "5px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "one-column-empty",
      "container": {
        "style": {
          "background-color": "#505659"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#000000",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 12,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: center; line-height: 14px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 28px; line-height: 14px; font-family: inherit;\" data-mce-style=\"font-size: 28px; line-height: 14px; font-family: inherit;\">New Bee is here!</span></div>",
              "style": {
                "color": "#ffffff",
                "line-height": "120%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "30px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 14px; line-height: 16px; font-family: inherit;\">A free, online email editor with&nbsp;</span></div><div style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 14px; line-height: 16px; font-family: inherit;\">built-in responsive design&nbsp;</span></div>",
              "style": {
                "color": "#989898",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "30px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/macbook-bee.png",
              "href": "https://beefree.io"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "center",
              "width": 279
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-divider",
          "descriptor": {
            "divider": {
              "style": {
                "border-top": "5px solid transparent",
                "width": "100%"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "align": "center"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "5px",
          "padding-right": "0px",
          "padding-bottom": "5px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "one-column-image",
      "container": {
        "style": {
          "background-color": "transparent"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#333",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 12,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: left; line-height: 16px;\" data-mce-style=\"text-align: left;\"><span style=\"font-size: 28px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 28px; line-height: 16px; font-family: inherit;\">Ease of use</span></div>",
              "style": {
                "color": "#555555",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "25px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: left; line-height: 16px;\" data-mce-style=\"text-align: left;\"><span style=\"font-size: 14px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 14px; line-height: 16px; font-family: inherit;\">&nbsp;The Bee interface is very simple to use:</span></div><div style=\"font-size: 14px; text-align: left; line-height: 16px;\" data-mce-style=\"font-size: 14px; text-align: left;\"><span style=\"font-size: 14px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 14px; line-height: 16px; font-family: inherit;\">drag-&amp;-drop the different blocks</span></div>",
              "style": {
                "color": "#989898",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-button",
          "descriptor": {
            "button": {
              "label": "<div style=\"line-height: 28px;\" data-mce-style=\"line-height: 28px;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 28px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 28px;\">LEARN MORE</span></div>",
              "href": "http://www.mailup.it",
              "style": {
                "font-family": "inherit",
                "background-color": "#3AAEE0",
                "border-radius": "4px",
                "border-top": "0px solid transparent",
                "border-right": "0px solid transparent",
                "border-bottom": "0px solid transparent",
                "border-left": "0px solid transparent",
                "color": "#ffffff",
                "line-height": "240%",
                "width": "auto",
                "padding-top": "5px",
                "padding-right": "30px",
                "padding-bottom": "5px",
                "padding-left": "30px"
              }
            },
            "style": {
              "text-align": "left",
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "width": "100%"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/perspective-bee.jpg",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "right",
              "width": 482
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "30px",
          "padding-right": "0px",
          "padding-bottom": "30px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "two-columns-text",
      "container": {
        "style": {
          "background-color": "#3AAEE0"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#333",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 6,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/peace.png",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "center",
              "width": 201
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 22px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 22px; line-height: 16px; font-family: inherit;\">Peace of mind&nbsp;</span></div>",
              "style": {
                "color": "#ffffff",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "30px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">You don't have to worry about</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">the HTML of the message, and changing</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">one block does not affect the</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">of the content.</span></p><p style=\"line-height: 16px;\" data-mce-style=\"line-height: 14px;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">&nbsp;</span><br></p>",
              "style": {
                "color": "#9FD8F0",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "30px",
          "padding-right": "0px",
          "padding-bottom": "30px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }, {
        "grid-columns": 6,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/mobile-ready.png",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "center",
              "width": 128
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<div style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 22px; line-height: 16px; font-family: inherit;\" data-mce-style=\"font-size: 22px; line-height: 16px; font-family: inherit;\">Mobile-ready</span></div>",
              "style": {
                "color": "#ffffff",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "15px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">You don't have to worry about</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">the HTML of the message, and changing</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">one block does not affect the</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">of the content.</span></p><p style=\"line-height: 16px;\" data-mce-style=\"line-height: 14px;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">&nbsp;</span><br></p>",
              "style": {
                "color": "#9FD8F0",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "30px",
          "padding-right": "0px",
          "padding-bottom": "30px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "one-column-empty",
      "container": {
        "style": {
          "background-color": "transparent"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#000000",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 12,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-divider",
          "descriptor": {
            "divider": {
              "style": {
                "border-top": "5px solid transparent",
                "width": "100%"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "align": "center"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "5px",
          "padding-right": "0px",
          "padding-bottom": "5px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "two-columns-text",
      "container": {
        "style": {
          "background-color": "transparent"
        }
      },
      "content": {
        "style": {
          "background-color": "#505659",
          "color": "#333",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 6,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: right; line-height: 28px;\" data-mce-style=\"text-align: right;\"><span style=\"font-size: 28px; line-height: 28px; font-family: inherit;\" data-mce-style=\"font-size: 28px; line-height: 28px; font-family: inherit;\">Easy Export of</span></p><p style=\"text-align: right; line-height: 28px;\" data-mce-style=\"text-align: right;\"><span style=\"font-size: 28px; line-height: 28px; font-family: inherit;\" data-mce-style=\"font-size: 28px; line-height: 28px; font-family: inherit;\">Your Email</span></p>",
              "style": {
                "color": "#ffffff",
                "line-height": "240%"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "20px",
              "padding-right": "20px",
              "padding-bottom": "20px",
              "padding-left": "20px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: right; line-height: 21px;\" data-mce-style=\"text-align: right;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 21px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 21px;\">Save the email and export it as a zip file. The zip file contains the HTML version of the email and an image folder. The zip file can then be imported into your favorite email marketing platform.&nbsp;</span></p>",
              "style": {
                "color": "#989898",
                "line-height": "180%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "20px",
              "padding-right": "20px",
              "padding-bottom": "20px",
              "padding-left": "20px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-button",
          "descriptor": {
            "button": {
              "label": "<p style=\"line-height: 28px;\" data-mce-style=\"line-height: 28px;\"><span style=\"font-size: 16px; line-height: 28px;\" data-mce-style=\"font-size: 16px; line-height: 28px;\">Learn more</span></p>",
              "href": "http://www.mailup.it",
              "style": {
                "font-family": "inherit",
                "background-color": "#3AAEE0",
                "border-radius": "4px",
                "border-top": "0px solid transparent",
                "border-right": "0px solid transparent",
                "border-bottom": "0px solid transparent",
                "border-left": "0px solid transparent",
                "color": "#ffffff",
                "line-height": "240%",
                "width": "55%",
                "padding-top": "5px",
                "padding-right": "20px",
                "padding-bottom": "5px",
                "padding-left": "20px"
              }
            },
            "style": {
              "text-align": "right",
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "width": "100%"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "20px",
          "padding-right": "0px",
          "padding-bottom": "30px",
          "padding-left": "5px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }, {
        "grid-columns": 6,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/zip-file.png",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "center",
              "width": 117
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "30px",
          "padding-right": "0px",
          "padding-bottom": "30px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "one-column-empty",
      "container": {
        "style": {
          "background-color": "transparent"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#000000",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 12,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-divider",
          "descriptor": {
            "divider": {
              "style": {
                "border-top": "5px solid transparent",
                "width": "100%"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "align": "center"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "5px",
          "padding-right": "0px",
          "padding-bottom": "5px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "one-column-image",
      "container": {
        "style": {
          "background-color": "#E2E2E2"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#333",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 12,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/blue-mail.png",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "center",
              "width": 289
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: center; line-height: 21px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 28px; font-family: inherit; line-height: 21px;\" data-mce-style=\"font-size: 28px; font-family: inherit; line-height: 21px;\">Online, Accessible</span></p><p style=\"text-align: center; line-height: 21px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 28px; font-family: inherit; line-height: 21px;\" data-mce-style=\"font-size: 28px; font-family: inherit; line-height: 21px;\">to Anyone, and Free!</span></p>",
              "style": {
                "color": "#555555",
                "line-height": "180%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "30px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">BeeFree is intended for anyone to use.&nbsp;</span></p><p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-size: 14px; font-family: inherit; line-height: 16px;\" data-mce-style=\"font-size: 14px; font-family: inherit; line-height: 16px;\">No sign up of any kind is required.</span></p>",
              "style": {
                "color": "#989898",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-divider",
          "descriptor": {
            "divider": {
              "style": {
                "border-top": "1px solid #D0D0D0",
                "width": "50%"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "align": "center"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-text",
          "descriptor": {
            "text": {
              "html": "<p style=\"text-align: center; line-height: 16px;\" data-mce-style=\"text-align: center;\"><span style=\"font-family: inherit; font-size: 22px; line-height: 16px;\" data-mce-style=\"font-family: inherit; font-size: 22px; line-height: 16px;\"><em>Your feedback is welcome!</em></span></p>",
              "style": {
                "color": "#505659",
                "line-height": "140%",
                "font-family": "inherit"
              },
              "computedStyle": {
                "linkColor": "#0000FF"
              }
            },
            "style": {
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            }
          }
        }, {
          "type": "mailup-bee-newsletter-modules-button",
          "descriptor": {
            "button": {
              "label": "<p style=\"line-height: 30px;\" data-mce-style=\"line-height: 30px;\"><span style=\"font-size: 16px; font-family: inherit; line-height: 30px;\" data-mce-style=\"font-size: 16px; font-family: inherit; line-height: 30px;\">Contact us&nbsp;</span></p>",
              "href": "http://www.mailup.it",
              "style": {
                "font-family": "inherit",
                "background-color": "#3AAEE0",
                "border-radius": "4px",
                "border-top": "0px solid transparent",
                "border-right": "0px solid transparent",
                "border-bottom": "0px solid transparent",
                "border-left": "0px solid transparent",
                "color": "#ffffff",
                "line-height": "240%",
                "width": "30%",
                "padding-top": "5px",
                "padding-right": "20px",
                "padding-bottom": "5px",
                "padding-left": "20px"
              }
            },
            "style": {
              "text-align": "center",
              "padding-top": "10px",
              "padding-right": "10px",
              "padding-bottom": "10px",
              "padding-left": "10px"
            },
            "computedStyle": {
              "width": "100%"
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "30px",
          "padding-right": "0px",
          "padding-bottom": "25px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }, {
      "type": "two-columns-image-text",
      "container": {
        "style": {
          "background-color": "#505659"
        }
      },
      "content": {
        "style": {
          "background-color": "transparent",
          "color": "#333",
          "width": "600px"
        }
      },
      "columns": [{
        "grid-columns": 4,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-image",
          "descriptor": {
            "image": {
              "alt": "Image",
              "src": "https://beefree.s3.amazonaws.com/public/img/logo-bee-footer.png",
              "href": "http://www.mailup.it"
            },
            "style": {
              "width": "100%"
            },
            "computedStyle": {
              "class": "left",
              "width": 65
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "30px",
          "padding-right": "10px",
          "padding-bottom": "30px",
          "padding-left": "10px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }, {
        "grid-columns": 8,
        "modules": [{
          "type": "mailup-bee-newsletter-modules-social",
          "descriptor": {
            "iconsList": {
              "icons": [{
                "type": "follow",
                "name": "facebook",
                "image": {
                  "prefix": "https://www.facebook.com/",
                  "alt": "facebook",
                  "src": "https://pre-bee-resources.s3.amazonaws.com/public/resources/social-networks-icon-sets/circle-color/facebook.png",
                  "title": "facebook",
                  "href": ""
                },
                "text": ""
              }, {
                "type": "follow",
                "name": "twitter",
                "image": {
                  "prefix": "http://twitter.com/",
                  "alt": "twitter",
                  "src": "https://pre-bee-resources.s3.amazonaws.com/public/resources/social-networks-icon-sets/circle-color/twitter.png",
                  "title": "twitter",
                  "href": ""
                },
                "text": ""
              }, {
                "type": "follow",
                "name": "google",
                "image": {
                  "prefix": "http://plus.google.com/",
                  "alt": "googleplus",
                  "src": "https://pre-bee-resources.s3.amazonaws.com/public/resources/social-networks-icon-sets/circle-color/googleplus.png",
                  "title": "googleplus",
                  "href": ""
                },
                "text": ""
              }]
            },
            "style": {
              "text-align": "right",
              "padding-top": "15px",
              "padding-right": "15px",
              "padding-bottom": "15px",
              "padding-left": "15px"
            },
            "computedStyle": {
              "padding": "0 5px 0 0",
              "iconsDefaultWidth": 32
            }
          }
        }],
        "style": {
          "background-color": "transparent",
          "padding-top": "5px",
          "padding-right": "0px",
          "padding-bottom": "5px",
          "padding-left": "0px",
          "border-top": "0px solid transparent",
          "border-right": "0px solid transparent",
          "border-bottom": "0px solid transparent",
          "border-left": "0px solid transparent"
        }
      }]
    }]
  }
}