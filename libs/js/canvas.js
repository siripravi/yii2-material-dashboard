 
        function point (x, y) {
            this.x = x;
            this.y = y;
        }
 
        function ring (center, minRadius, maxRadius) {
            this.center = center;
            this.minRadius = minRadius;
            this.maxRadius = maxRadius;
        }
 
        function arc (ring, startAngle, endAngle, text, alignment) {
            this.ring = ring;
            this.startAngle = startAngle;
            this.endAngle = endAngle;
            this.text = text;
            this.alignment = (alignment != undefined) ? alignment : TextAlignment.Center;
            this.createArcAfter = function (angle, text) {
                return new arc(this.ring, this.endAngle, this.endAngle + angle, text);
            };
            this.createArcAfterUpTo = function (upToArc, text) {
                return new arc(this.ring, this.endAngle, upToArc.startAngle, text);
            };
            this.isInside = function (pos) {
                // http://stackoverflow.com/questions/6270785/how-to-determine-whether-a-point-x-y-is-contained-within-an-arc-section-of-a-c
                // Angle = arctan(y/x); Radius = sqrt(x * x + y * y);
                var result = false;
                var radius = Trig.distanceBetween2Points(pos, this.ring.center);
                // we calculate atan only if the radius is OK
                if ((radius >= this.ring.minRadius) && (radius <= this.ring.maxRadius)) {
                    var angle = Trig.angleBetween2Points(this.ring.center, pos);
 
                    var a = (angle < 0) ? angle + 2 * Math.PI : angle;
                    var sa = this.startAngle;
                    var ea = this.endAngle;
 
                    if (ea > 2 * Math.PI) {
                        sa -= 2 * Math.PI;
                        ea -= 2 * Math.PI;
                    }
 
                    if (sa > ea) {
                        sa -= 2 * Math.PI;
                    }
 
                    if ((a >= sa) && (a <= ea)) {
                        result = true;
                    }
                }
                return result;
            };
 
            this.higlightIfInside = function (pos) {
                if (this.isInside(pos)) {
                    arc.isHighlighted = this;
                    drawArc(this, true);
                }
            };
 
            this.doTask = function (pos) {
                if (this.isInside(pos)) {
                    alert(this.text);
                }
            };
 
            if (arc.arcs == undefined) {
                arc.arcs = new Array();
            }
            arc.arcs.push(this);
        }
 
        arc.lastHighlighted = null;
        arc.isHighlighted = null;
 
        arc.drawAll = function () {
            arc.arcs.forEach(function (a) {
                drawArc(a);
            });
        }
        
        arc.checkMousePos = function (pos) {
            arc.lastHighlighted = arc.isHighlighted;
            arc.isHighlighted = null;
            arc.arcs.forEach(function (a) {
                a.higlightIfInside(pos);
            });
            if ((arc.lastHighlighted != null) && (arc.isHighlighted != arc.lastHighlighted)) {
                drawArc(arc.lastHighlighted);
            }
 
            // set cursor according to the highlight status
            canvas.style.cursor = (arc.isHighlighted != null) ? 'pointer' : 'default';
        }
 
        arc.doTasks = function (pos) {
            arc.arcs.forEach(function (a) {
                a.doTask(pos);
            });
        }
 
        // http://www.tricedesigns.com/2012/01/04/sketching-with-html5-canvas-and-brush-images/
        var Trig = {
            distanceBetween2Points: function (point1, point2) {
                var dx = point2.x - point1.x;
				var dy = point2.y - point1.y;
                return Math.sqrt(Math.pow(dx, 2) + Math.pow(dy, 2));
            },
            angleBetween2Points: function (point1, point2) {
                var dx = point2.x - point1.x;
                var dy = point2.y - point1.y;
                return Math.atan2(dy, dx);
            },
            angleDiff: function (startAngle, endAngle) {
                var angleDiff = (startAngle - endAngle);
                angleDiff += (angleDiff > Math.PI) ? -2 * Math.PI : (angleDiff < -Math.PI) ? 2 * Math.PI : 0
                return angleDiff;
            }
        }
		function drawArc(arc, isHighlighted) {
            var gapsAtEdgeAngle = Math.PI / 400;
            var isCounterClockwise = false;
 
            var startAngle = arc.startAngle + gapsAtEdgeAngle;
            var endAngle = arc.endAngle - gapsAtEdgeAngle;
            context.beginPath();
            var radAvg = (arc.ring.maxRadius + arc.ring.minRadius) / 2;
            context.arc(arc.ring.center.x, arc.ring.center.y, radAvg, startAngle, endAngle, isCounterClockwise);
            context.lineWidth = arc.ring.maxRadius - arc.ring.minRadius;
 
            // line color
            context.strokeStyle = isHighlighted ? 'grey' : 'lightgrey';
            context.stroke();
 
            drawTextAlongArc(arc.text, center, radAvg, startAngle, endAngle, arc.alignment);
        }
 
        function drawTextAlongArc(text, center, radius, startAngle, endAngle, alignment) {
            var fontSize = 12;
            var lineSpacing = 4;
            var lines = text.split('\n');
            var lineCount = lines.length;
 
            radius = radius + (lineCount - 1) / 2 * (fontSize + lineSpacing)
 
            lines.forEach(function (line) {
                drawLineAlongArc(context, line, center, radius, startAngle, endAngle, fontSize, alignment);
                radius -= (fontSize + lineSpacing);
            });           
        }
 
        function drawLineAlongArc(context, str, center, radius, startAngle, endAngle, fontSize, alignment) {
            var len = str.length, s;
            context.save();
 
            context.font = fontSize + 'pt Calibri';
            context.textAlign = 'center';
            context.fillStyle = 'black';
 
            // check if the arc is more at the top or at the bottom part of the ring
            var upperPart = ((startAngle + endAngle) / 2) > Math.PI;
 
            // reverse the aligment direction if the arc is at the bottom
            // Center and Justify is neutral in this sence
            if (!upperPart) {
                if (alignment == TextAlignment.Left) {
                    alignment = TextAlignment.Right;
                }
                else if (alignment == TextAlignment.Right) {
                    alignment = TextAlignment.Left;
                }
            }
 
            //var metrics = context.measureText(str);
            var metrics = context.measureText(str.replace(/./gi, 'W'));
            var textAngle = metrics.width / (radius - fontSize / 2);
 
            var gapsAtEdgeAngle = Math.PI / 80;
 
            if (alignment == TextAlignment.Left) {
                startAngle += gapsAtEdgeAngle;
                endAngle = startAngle + textAngle;
            }
            else if (alignment == TextAlignment.Center) {
                var ad = (Trig.angleDiff(endAngle, startAngle) - textAngle) / 2;
                startAngle += ad;
                endAngle -= ad;
            }
            else if (alignment == TextAlignment.Right) {
                endAngle -= gapsAtEdgeAngle;
                startAngle = endAngle - textAngle;
            }
            else if (alignment == TextAlignment.Justify) {
                startAngle += gapsAtEdgeAngle;
                endAngle -= gapsAtEdgeAngle;
            }
            else {
                // alignmet not supported
                // show some kind of warning
                // or fallback to default?
            }
 
            // calculate text height and adjust radius according to font size
            if (upperPart) {
                // if it is in the upper part, we have to change the orientation as well -> multiply by -1
                radius = -1 * (radius - fontSize / 2);
            }
            else {
                radius += fontSize / 2; //*
            }
 
            context.translate(center.x, center.y);
 
            var angleStep = Trig.angleDiff(endAngle, startAngle) / len;
 
            if (upperPart) {
                angleStep *= -1;
                context.rotate(startAngle + Math.PI / 2);
            }
            else {
                context.rotate(endAngle - Math.PI / 2);
            }
 
            context.rotate(angleStep / 2);
 
            for (var n = 0; n < len; n++) {
                context.rotate(-angleStep);
                context.save();
                context.translate(0, radius);
                s = str[n];
                context.fillText(s, 0, 0);
                context.restore();
            }
            context.restore();
        }
 
 
        function track_mouse(e) {
            var target = e.currentTarget;
            var mousePos = getMousePos(target, e);
 
            arc.checkMousePos(mousePos);
        }
 
        function click_mouse(e) {
            var target = e.currentTarget;
            var mousePos = getMousePos(target, e);
 
            arc.doTasks(mousePos);
        }
 
        function getMousePos(canvas, evt) {
            var rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }