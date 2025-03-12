<?php if(!empty($spheres)): ?>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <h2>Выберите сферу деятельности</h2>

    <div class="sphere-list">
      <button id="backBtn" style="display:none;">Назад</button>

      <?php foreach($spheres as $sphereName => $types): ?>
        <div class="sphere-block">
          <h3><?php echo htmlspecialchars($sphereName); ?></h3>
          <ul style="display:none;">
            <?php foreach($types as $type): ?>
              <li data-stid="<?php echo $type['stid']; ?>">
                <?php echo htmlspecialchars($type['stname']); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>