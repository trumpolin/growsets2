"use client";
import ArticleFacet from "./ArticleFacet";

export default function CirculationFanFacet() {
  const category = process.env.NEXT_PUBLIC_CIRCULATION_FAN_CATEGORY_ID || "";
  return (
    <ArticleFacet
      category={category}
      selectionKey="circulationFan"
      title="Umluftventilator"
      queryKey={["circulationFanArticles"]}
    />
  );
}
