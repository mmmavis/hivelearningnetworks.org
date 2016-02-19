    <?php get_template_part( "partials/footer-content" ); ?>


    <script src="<?php echo get_template_directory_uri(); ?>/js/locations-data-loader.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/d3.v3.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/topojson.v1.min.js"></script>
    <script>
      var pathToTheme = "<?php bloginfo('template_directory') ?>" + "/";

      var viewBoxW = 1000;
      var viewBoxH = 1000;

      var clipHeight = 700; // use to clip Antarctica

      var projection = d3.geo.mercator()
          .translate([viewBoxW / 2, viewBoxH / 2]);

      var path = d3.geo.path()
          .projection(projection);

      var svg = d3.select("body #hive-map").append("svg")
          .attr("viewBox", "0 0 " + viewBoxW + " " + clipHeight)
          .attr("width", "100%")
          .attr("height", "100%");

      // Clip Antarctica from the map
      var defs = svg.append("svg:defs");
      var clipPath = defs.append("svg:clipPath")
                      .attr("id","clipAntarctica");
      clipPath.append("svg:rect")
              .attr("x", "0")
              .attr("y", "0")
              .attr("width", viewBoxW)
              .attr("height", clipHeight);

      var g = svg.append("g")
              .attr("clip-path", "url(#clipAntarctica)");

      var r = 7;

      d3.json( pathToTheme + "world-110m.json", function(error, world) {
        // load locations to map and highlight cities on map
        d3.csv(pathToTheme + "hive-locations/networks.csv", function(error, data) {
          dropHexagonToMap(data,"networks");
        });
        d3.csv(pathToTheme + "hive-locations/communities.csv", function(error, data) {
          dropHexagonToMap(data,"communities");
        });
        // draw map
        console.log(topojson.feature(world, world.objects.countries).features);
        g.selectAll("path")
          .data(topojson.feature(world, world.objects.countries).features)
          .enter()
          .append("path")
          .attr("d", path);
      });

      function dropHexagonToMap(data,hiveType) {
        g.selectAll("circle")
          .data(data)
          .enter()
          .append("polygon")
          .attr("class", function(d) {
            return hiveType + " " + d.city.replace(/\s+/g, '-').toLowerCase();
          })
          .attr("points", function(d) {
            var cx = projection( [d.lon,d.lat] )[0];
            var cy = projection( [d.lon,d.lat] )[1];
            return hexagonPoints(r,cx,cy);
          })
          .attr("opacity", "0.8");
      }

      function hexagonPoints(r, cx, cy) {
        var points =  cx  + "," + (cy-r) + " "  +
                      (cx + ( Math.sqrt(3)/2 ) * r )+ "," + (cy-r/2) + " " +
                      (cx + ( Math.sqrt(3)/2 ) * r )+ "," + (cy+r/2) + " " +
                      cx + "," + (cy+r) + " " +
                      (cx - ( Math.sqrt(3)/2 ) * r )+ "," + (cy+r/2) + " " +
                      (cx - ( Math.sqrt(3)/2 ) * r )+ "," + (cy-r/2) ;
        return points;
      }
    </script>


    <?php wp_footer(); ?>

    <?php get_template_part( "partials/footer-script" ); ?>
  </body>
</html>
