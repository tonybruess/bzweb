var Flags = new Hash({
  "Good":
  [
    "Agility",
    "Burrow",
    "Cloaking",
    "Genocide",
    "Guided Missile",
    "High Speed",
    "Identify",
    "Invisible Bullet",
    "Jumping",
    "Laser",
    "Machine Gun",
    "Masquerade",
    "Narrow",
    "Oscillation Overthruster",
    "Phantom Zone",
    "Quick Turn",
    "Rapid Fire",
    "Ricochet",
    "Seer",
    "Shield",
    "Shock Wave",
    "Stealth",
    "Steam Roller",
    "Super Bullet",
    "Thief",
    "Tiny",
    "Useless",
    "Wings"
  ],
  "Bad":
  [
    "Blindness",
    "Bouncy",
    "Colorblindness",
    "Forward Only",
    "Jamming",
    "Left Turn Only",
    "Momentum",
    "No Jumping",
    "Obesity",
    "Reverse Controls",
    "Reverse Only",
    "Right Turn Only",
    "Trigger Happy",
    "Wide Angle"
  ],
  "Team":
  [
    "Red Flag",
    "Green Flag",
    "Blue Flag",
    "Purple Flag"
  ]
});

var FlagCounts = new Hash();
var AllFlags = $A(Flags.Good).extend(Flags.Bad).extend(Flags.Team);
AllFlags.each(function(flag) { FlagCounts[flag] = 0; });

function UpdateFlagJSON()
{
  $("Flags").set("value", JSON.encode(FlagCounts));
}

function UpdateFlag(name)
{
  var flag = $(name + "Flag");
  var num = FlagCounts[name];
  
  if (flag == null)
  {
    if (num > 0)
    {
      flag = new Element("option", { "value": name, "id": name + "Flag" })
        .addEvent("dblclick", function() { RemoveFlag(this.value); })
        .inject($("FlagList"), "bottom");
    }
    else
      return;
  }

  if(num <= 0)
  {
    flag.destroy();
  }
  else
  {
    flag.set("html", num + " x " + name);
  }

  UpdateFlagJSON();
}

function AddFlag(name, num)
{
  var numToAdd = num || $("NumFlagsToAdd").get("value").toInt();
  if(isNaN(numToAdd) || numToAdd == 0)
    return;
    
  FlagCounts[name] += numToAdd;
  var num = FlagCounts[name];

  UpdateFlag(name);
}

function RemoveFlag(name, num)
{
  var numToRemove = num || $("NumFlagsToRemove").get("value").toInt();
  if (isNaN(numToRemove) || numToRemove == 0)
    return;

  FlagCounts[name] -= Math.min(numToRemove, FlagCounts[name]);

  UpdateFlag(name);
}

function AddOptGroupToAvailable(label)
{
  new Element("optgroup", { "label": label }).inject($("AvailableFlagList"), "bottom");
}

function AddFlagToAvailable(name)
{
  new Element("option", { "html": "&nbsp;&nbsp;&nbsp;&nbsp;" + name, "value": name })
    .addEvent("dblclick", function() { AddFlag(this.value); })
    .inject($("AvailableFlagList"), "bottom");
}

window.addEvent("domready", function()
{
  AddOptGroupToAvailable("Good Flags");
  Flags.Good.each(AddFlagToAvailable);

  AddOptGroupToAvailable("Bad Flags");
  Flags.Bad.each(AddFlagToAvailable);

  AddOptGroupToAvailable("Extra Team Flags");
  Flags.Team.each(AddFlagToAvailable);

  $("AddButton").addEvent("click", function()
  {
    var selected = $("AvailableFlagList").getSelected();
    for (var i = 0; i < selected.length; i++)
      AddFlag(selected[i].get("value"));
  });

  $("RemoveButton").addEvent("click", function()
  {
    var selected = $("FlagList").getSelected();
    for (var i = 0; i < selected.length; i++)
      RemoveFlag(selected[i].get("value"));
  });

  UpdateFlagJSON();
});