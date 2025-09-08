"use client";
import ArticleFacet from "./ArticleFacet";

export default function CirculationFanFacet() {
  return (
    <ArticleFacet
      category="circulation-fan"
      selectionKey="circulationFan"
      title="Umluftventilator"
      queryKey={["circulationFanArticles"]}
    />
  );
}
